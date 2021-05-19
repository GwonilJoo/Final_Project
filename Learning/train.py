from dataloader import *
from model import *

import asyncio
import websockets
import functools
import json
import pymysql


def validation(epoch, model, data_loader, criterion, device):
    print('Start validation #{}'.format(epoch))
    model.eval()
    with torch.no_grad():
        total = 0
        correct = 0
        total_loss = 0
        cnt = 0
        for i, (imgs, labels) in enumerate(data_loader):
            imgs, labels = imgs.to(device), labels.to(device)
            outputs = model(imgs)
            loss = criterion(outputs, labels)
            total += imgs.size(0)
            _, argmax = torch.max(outputs, 1)
            correct += (labels == argmax).sum().item()
            total_loss += loss.item()
            cnt += 1
        avrg_loss = total_loss / cnt
        avrg_acc = correct / total
        print('Validation #{}  Accuracy: {:.2f}%  Average Loss: {:.4f}'.format(epoch, avrg_acc*100, avrg_loss))
    model.train()
    return avrg_loss, avrg_acc


def save_model(model, saved_dir, file_name='best_model.pt'):
    os.makedirs(saved_dir, exist_ok=True)
    check_point = {
        'net': model.state_dict()
    }
    output_path = os.path.join(saved_dir, file_name)
    torch.save(model, output_path)


#클라이언트 접속이 되면 호출된다.
async def accept(websocket, path, device):
    #await websocket.send("sstart");
    #try:
        #await websocket.send("start");
        data = await websocket.recv()
        model_args = json.loads(data)
        print("receive: ", model_args)

        
        model_name = model_args['model']
        epochs = int(model_args['epochs'])
        batch_size = int(model_args['batch_size'])
        save_file = model_args['save_file']
        random_seed = int(model_args['random_seed'])
        data_dir = model_args['data_dir']

        user_id = data_dir.split('/')[2]
        dataset_name = data_dir.split('/')[3]

        print(1)
        # mysql db connet
        db_conn = pymysql.connect(
            user='root',
            passwd='pass',
            host='211.47.119.192',
            db='Final_db',
            charset='utf8',
            autocommit=True
        )
        print(2)
        cursor = db_conn.cursor()
        print(3)
        sql = "insert into save_weight(user_id, dataset, save_name, model) values(%s, %s, %s, %s)"
        cursor.execute(sql, (user_id, dataset_name, save_file + '_best.pth', model_name))

        sql = "insert into save_weight(user_id, dataset, save_name, model) values(%s, %s, %s, %s)"
        cursor.execute(sql, (user_id, dataset_name, save_file + '_last.pth', model_name))
        print(4)

        #set_seed(device, args.random_seed)
        torch.manual_seed(random_seed)

        # dataset
        # train_data = CatDogDataset(data_dir=data_dir, mode='train', transform=data_transforms['train'])
        # val_data = CatDogDataset(data_dir=data_dir, mode='val', transform=data_transforms['val'])

        # dataloader
        # train_loader = DataLoader(train_data, batch_size=batch_size, shuffle=True, drop_last=True)
        # val_loader = DataLoader(val_data, batch_size=batch_size, shuffle=False, drop_last=True)
        class_names, train_loader = Train_loader(data_dir, batch_size)
        class_names, val_loader = Valid_loader(data_dir, batch_size)

        model = resnet(len(class_names)).to(device)

        # model & function
        #if model_name == "resnet":
        #model = SimpleCNN().to(device)

        criterion = nn.CrossEntropyLoss()
        optimizer = torch.optim.Adam(model.parameters())

        print('Start training..')
        best_loss = 9999999
        for epoch in range(epochs):
            #await websocket.send("epoch : " + str(epoch));
            total_loss, total_acc, numOfData = 0, 0, 0
            for i, (imgs, labels) in enumerate(train_loader):
                imgs, labels = imgs.to(device), labels.to(device)
                outputs = model(imgs)
                loss = criterion(outputs, labels)

                optimizer.zero_grad()
                loss.backward()
                optimizer.step()

                _, argmax = torch.max(outputs, 1)
                accuracy = (labels == argmax).float().mean()

                total_loss += loss.item()
                #total_acc += accuracy.item()
                total_acc += (labels == argmax).float().sum().item()
                numOfData += len(labels)

                print('Epoch [{}/{}], Step [{}/{}], Loss: {:.4f}, Accuracy: {:.2f}%'.format(
                    epoch+1, epochs, i+1, len(train_loader), loss.item(), accuracy.item() * 100))

                message = json.dumps({"type": "step", "step": i+1, "total_step": len(train_loader)})
                await websocket.send(message)
                await asyncio.sleep(1)

                

            #await websocket.send(str(loss.item()));
            total_loss /= len(train_loader)
            total_acc /= numOfData

            avrg_loss, avrg_acc = validation(epoch + 1, model, val_loader, criterion, device)
            if avrg_loss < best_loss:
                print('Best performance at epoch: {}'.format(epoch + 1))
                print('Save model in', data_dir + '/saved')
                best_loss = avrg_loss
                torch.save(model.state_dict(), data_dir+'/saved/'+ save_file + '_best.pth')
            
            torch.save(model.state_dict(), data_dir+'/saved/'+ save_file + '_last.pth')

            message = json.dumps({"type": "chart", "train_loss": total_loss, "train_acc": total_acc, 
                                "val_loss": avrg_loss, "val_acc": avrg_acc, "epoch": epoch+1, "epochs": epochs})
            await websocket.send(message)
            await asyncio.sleep(1)
        
        message = json.dumps({"type": 'finish'})
        await websocket.send(message) 

    # except:
    #     print("Not working!!")

    # finally:
    #     print("end")
    #     #exit(0)


def main():
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    print(device)

    # 웹 소켓 서버 생성.호스트는 localhost에 port는 9998로 생성한다.

    bound_handler = functools.partial(accept, device=device)
    start_server = websockets.serve(bound_handler, "0.0.0.0", 9998)
    # 비동기로 서버를 대기한다.
    asyncio.get_event_loop().run_until_complete(start_server)
    asyncio.get_event_loop().run_forever()


if __name__ == "__main__":
    main()

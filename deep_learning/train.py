from dataloader import *
from model import *

import asyncio
import websockets
import functools

parser = argparse.ArgumentParser(description='cls')
parser.add_argument('--learning_rate', type=float, default=1e-4)
parser.add_argument('--num_epochs', type=int, default=10)
parser.add_argument('--batch_size', type=int, default=100)
parser.add_argument('--data_dir', type=str, default="../dataset/gwonil/my_cat_dog")
parser.add_argument('--saved_dir', type=str, default="../dataset/gwonil/my_cat_dog/saved")
parser.add_argument('--model_path', type=str, default=None)
parser.add_argument('--random_seed', type=int, default='222')
args = parser.parse_args()



def train(model, train_loader, val_loader, criterion, optimizer, args, val_every, device):
    print('Start training..')
    best_loss = 9999999
    for epoch in range(args.num_epochs):
        for i, (imgs, labels) in enumerate(train_loader):
            imgs, labels = imgs.to(device), labels.to(device)
            outputs = model(imgs) 
            loss = criterion(outputs, labels)   

            optimizer.zero_grad()          
            loss.backward()           
            optimizer.step()           

            _, argmax = torch.max(outputs, 1)
            accuracy = (labels == argmax).float().mean()

            print('Epoch [{}/{}], Step [{}/{}], Loss: {:.4f}, Accuracy: {:.2f}%'.format(
                epoch+1, args.num_epochs, i+1, len(train_loader), loss.item(), accuracy.item() * 100))

        if (epoch + 1) % val_every == 0:
            avrg_loss = validation(epoch + 1, model, val_loader, criterion, device)
            if avrg_loss < best_loss:
                print('Best performance at epoch: {}'.format(epoch + 1))
                print('Save model in', args.saved_dir)
                best_loss = avrg_loss
                save_model(model, args.saved_dir)


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
            total_loss += loss
            cnt += 1
        avrg_loss = total_loss / cnt
        print('Validation #{}  Accuracy: {:.2f}%  Average Loss: {:.4f}'.format(epoch, correct / total * 100, avrg_loss))
    model.train()
    return avrg_loss


def save_model(model, saved_dir, file_name='best_model.pt'):
    os.makedirs(saved_dir, exist_ok=True)
    check_point = {
        'net': model.state_dict()
    }
    output_path = os.path.join(saved_dir, file_name)
    torch.save(check_point, output_path)


# 클라이언트 접속이 되면 호출된다.
async def accept(websocket, path, model, train_loader, val_loader, criterion, optimizer, args, val_every, device):
    #await websocket.send("sstart");
    try:
        #await websocket.send("start");

        print('Start training..')
        best_loss = 9999999
        for epoch in range(args.num_epochs):
            #await websocket.send("epoch : " + str(epoch));
            for i, (imgs, labels) in enumerate(train_loader):
                imgs, labels = imgs.to(device), labels.to(device)
                outputs = model(imgs) 
                loss = criterion(outputs, labels)   

                optimizer.zero_grad()          
                loss.backward()           
                optimizer.step()           

                _, argmax = torch.max(outputs, 1)
                accuracy = (labels == argmax).float().mean()

                await websocket.send(str(loss.item()));
                await asyncio.sleep(1)

                print('Epoch [{}/{}], Step [{}/{}], Loss: {:.4f}, Accuracy: {:.2f}%'.format(
                    epoch+1, args.num_epochs, i+1, len(train_loader), loss.item(), accuracy.item() * 100))

            if (epoch + 1) % val_every == 0:
                avrg_loss = validation(epoch + 1, model, val_loader, criterion, device)
                if avrg_loss < best_loss:
                    print('Best performance at epoch: {}'.format(epoch + 1))
                    print('Save model in', args.saved_dir)
                    best_loss = avrg_loss
                    save_model(model, args.saved_dir)

        #await websocket.send("Done!")
    
    except:
        print("Not working!!")

    finally:
        print("end")
        #exit(0)


def main():
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    print(device)

    #set_seed(device, args.random_seed)
    torch.manual_seed(args.random_seed)

    # dataset
    train_data = CatDogDataset(data_dir=args.data_dir, mode='train', transform=data_transforms['train'])
    val_data = CatDogDataset(data_dir=args.data_dir, mode='val', transform=data_transforms['val'])

     # dataloader
    train_loader = DataLoader(train_data, batch_size=args.batch_size, shuffle=True, drop_last=True)
    val_loader = DataLoader(val_data, batch_size=args.batch_size, shuffle=False, drop_last=True)

    # model & function
    model = SimpleCNN().to(device)

    if args.model_path is not None:
        checkpoint = torch.load(args.model_path)
        state_dict = checkpoint['net']
        model.load_state_dict(state_dict)

    criterion = nn.CrossEntropyLoss()
    optimizer = torch.optim.Adam(model.parameters(), lr=args.learning_rate)

    val_every = 1
    #train(model, train_loader, val_loader, criterion, optimizer, args, val_every, device)
    
    # 웹 소켓 서버 생성.호스트는 localhost에 port는 9998로 생성한다.

    bound_handler = functools.partial(accept, model=model, train_loader=train_loader, val_loader=val_loader, 
                                        criterion=criterion, optimizer=optimizer, args=args, val_every=val_every, device=device)
    start_server = websockets.serve(bound_handler, "localhost", 9998);
    # 비동기로 서버를 대기한다.
    asyncio.get_event_loop().run_until_complete(start_server);
    asyncio.get_event_loop().run_forever();




if __name__ == "__main__":
    main()
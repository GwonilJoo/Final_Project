from dataloader import *
from model import *
from sklearn.metrics import classification_report

import asyncio
import websockets
import functools
import json
import pymysql
from PIL import Image

def class_acc(result, class_names):
    chart_src = []
    for class_name in class_names:
        acc = round(result[class_name]['precision']*100,2)
        chart_src.append([class_name,acc])
    
    return chart_src

#클라이언트 접속이 되면 호출된다.
async def accept(websocket, path, device):
    #try:
        #await websocket.send("sstart");
        data = await websocket.recv()
        model_args = json.loads(data)
        print("receive: ", model_args)

        model_name = model_args['model']
        save_file = model_args['save_file']
        data_dir = model_args['data_dir']

        class_names, test_loader = Test_loader(data_dir, 100)
        model = resnet(len(class_names)).to(device)
        model.load_state_dict(torch.load(save_file))

        print('class_names: ', class_names)

        if model_args['type'] == 'test':
            print('Start test..')
            model.eval()
            with torch.no_grad():
                correct = 0
                total = 0

                pred = []
                true = []
                for i, (imgs, labels) in enumerate(test_loader):
                    imgs, labels = imgs.to(device), labels.to(device)
                    print(imgs.shape)
                    outputs = model(imgs)
                    _, argmax = torch.max(outputs, 1)
                    total += len(labels)
                    correct += (labels == argmax).sum().item()

                    # print(argmax)
                    # print(labels)
                    pred.extend(list(argmax.to('cpu')))
                    true.extend(list(labels.to('cpu')))

                    message = json.dumps({"type": "step", "step": i+1, "total_step": len(test_loader)})
                    await websocket.send(message)
                    await asyncio.sleep(1)

                result = classification_report(true, pred, target_names=class_names, output_dict=True)

                total_acc = correct / total * 100
                message = json.dumps({"type": "acc", "total_acc": total_acc, "result": class_acc(result, class_names)})
                await websocket.send(message)
                await asyncio.sleep(1)
                print('Test accuracy for {} images: {:.2f}%'.format(total, correct / total * 100))
        
        else:
            print('Start inference..')
            model.eval()
            with torch.no_grad():
                img = Image.open('tmp/input.jpg')
                #img = img.resize((IMG_SIZE, int(img.height * IMG_SIZE / img.width)))
                
                input_img = data_transforms['test'](img).to(device)
                input_img = input_img.unsqueeze(0)
                print(input_img.shape)
                out = model(input_img)
                
                _, argmax = torch.max(out, 1)
                print(class_names[argmax])
                message = json.dumps({"pred":class_names[argmax]})
                await websocket.send(message)
                await asyncio.sleep(1)


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
    start_server = websockets.serve(bound_handler, "0.0.0.0", 9996)
    # 비동기로 서버를 대기한다.
    asyncio.get_event_loop().run_until_complete(start_server)
    asyncio.get_event_loop().run_forever()


if __name__ == "__main__":
    main()

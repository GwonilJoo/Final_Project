from dataloader import *
from model import *

import asyncio
import websockets
import functools
import json

from fasterrcnn.detect import result_fasterrcnn, result_keypoint, result_segmentation, result_fasterrcnn_video


#클라이언트 접속이 되면 호출된다.
async def accept(websocket, path, device):
    #try:
        #await websocket.send("sstart");
        data = await websocket.recv()
        model_args = json.loads(data)
        print("receive: ", model_args)

        model_name = model_args['model']
        infer_type = model_args['type']

        print('model_name: ', model_name)

        if infer_type == "infer_video":
            model = faster_rcnn().to(device)
            model.eval()
            with torch.no_grad():
                result_fasterrcnn_video(model, device)

        else:
            if model_name == "faster_rcnn":
                model = faster_rcnn().to(device)
                model.eval()
                with torch.no_grad():
                    result_fasterrcnn(model, device)

            elif model_name == "keypoint":
                model = keypoint()
                model.eval()
                with torch.no_grad():
                    result_keypoint(model)
            
            else:
                model = segmentation()
                model.eval()
                with torch.no_grad():
                    result_segmentation(model)

        await websocket.send("")
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
    start_server = websockets.serve(bound_handler, "0.0.0.0", 9997)
    # 비동기로 서버를 대기한다.
    asyncio.get_event_loop().run_until_complete(start_server)
    asyncio.get_event_loop().run_forever()


if __name__ == "__main__":
    main()

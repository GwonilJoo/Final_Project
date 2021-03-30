import asyncio

# 웹 소켓 모듈을 선언한다.
import websockets
import functools

data = [1,2,3,4,5]

# 클라이언트 접속이 되면 호출된다.
async def accept(websocket, path, data):
    try:
        await websocket.send("start");
        for i in range(5):
            # 클라이언트로부터 메시지를 대기한다.
            #data = await websocket.recv();
            #print("receive : " + data);

            # 클라인언트로 echo를 붙여서 재 전송한다.
            await websocket.send("echo : " + str(data[i]));

    finally:
        print("end")
        #exit(0)


def main():
    # 웹 소켓 서버 생성.호스트는 localhost에 port는 9998로 생성한다.
    bound_handler = functools.partial(accept, data=data)
    start_server = websockets.serve(bound_handler, "localhost", 9998);

    # 비동기로 서버를 대기한다.
    asyncio.get_event_loop().run_until_complete(start_server);
    asyncio.get_event_loop().run_forever();


if __name__ == "__main__":
    main()
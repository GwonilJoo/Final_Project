# import socket
# import numpy
# import cv2

# UDP_IP = "127.0.0.1"
# UDP_PORT = 9505

# sock = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
# sock.bind((UDP_IP, UDP_PORT))

# s = [b'\xff' * 46080 for x in range(20)]

# fourcc = cv2.VideoWriter_fourcc(*'DIVX')
# out = cv2.VideoWriter('output.avi', fourcc, 25.0, (640, 480))

# while True:
#     picture = b''

#     data, addr = sock.recvfrom(46081)
#     s[data[0]] = data[1:46081]

#     if data[0] == 19:
#         for i in range(20):
#             picture += s[i]

#         frame = numpy.fromstring(picture, dtype=numpy.uint8)
#         frame = frame.reshape(480, 640, 3)
#         cv2.imshow("frame", frame)
#         out.write(frame)

#         if cv2.waitKey(1) & 0xFF == ord('q'):
#             cv2.destroyAllWindows()
#             break

import socket 
import cv2
import numpy
from queue import Queue
from _thread import *


enclosure_queue = Queue()


# 쓰레드 함수 
def threaded(client_socket, addr, queue): 

    print('Connected by :', addr[0], ':', addr[1]) 

    while True: 

        try:
            data = client_socket.recv(1024)

            if not data: 
                print('Disconnected by ' + addr[0],':',addr[1])
                break

            stringData = queue.get()
            client_socket.send(str(len(stringData)).ljust(16).encode())
            client_socket.send(stringData)

        except ConnectionResetError as e:

            print('Disconnected by ' + addr[0],':',addr[1])
            break
             
    client_socket.close() 


def webcam(queue):


    capture = cv2.VideoCapture(0)

    while True:
        ret, frame = capture.read()

        if ret == False:
            continue


        encode_param=[int(cv2.IMWRITE_JPEG_QUALITY),90]
        result, imgencode = cv2.imencode('.jpg', frame, encode_param)

        data = numpy.array(imgencode)
        stringData = data.tostring()

        queue.put(stringData)

        cv2.imshow('image', frame)
        
        key = cv2.waitKey(1)
        if key == 27:
            break


HOST = '127.0.0.1'
PORT = 9999

server_socket = socket.socket(socket.AF_INET, socket.SOCK_STREAM) 
server_socket.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
server_socket.bind((HOST, PORT)) 
server_socket.listen() 

print('server start')

start_new_thread(webcam, (enclosure_queue,))


while True: 

    print('wait')


    client_socket, addr = server_socket.accept() 
    start_new_thread(threaded, (client_socket, addr, enclosure_queue,)) 

server_socket.close() 


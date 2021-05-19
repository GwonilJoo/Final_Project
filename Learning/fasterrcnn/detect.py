import torchvision
import numpy
import torch
import argparse
import cv2
from PIL import Image

import torchvision.transforms as transforms
import numpy as np

import matplotlib.pyplot as plt
from matplotlib.path import Path
import matplotlib.patches as patches
import time

coco_names = [
    '__background__', 'person', 'bicycle', 'car', 'motorcycle', 'airplane', 'bus',
    'train', 'truck', 'boat', 'traffic light', 'fire hydrant', 'N/A', 'stop sign',
    'parking meter', 'bench', 'bird', 'cat', 'dog', 'horse', 'sheep', 'cow',
    'elephant', 'bear', 'zebra', 'giraffe', 'N/A', 'backpack', 'umbrella', 'N/A', 'N/A',
    'handbag', 'tie', 'suitcase', 'frisbee', 'skis', 'snowboard', 'sports ball',
    'kite', 'baseball bat', 'baseball glove', 'skateboard', 'surfboard', 'tennis racket',
    'bottle', 'N/A', 'wine glass', 'cup', 'fork', 'knife', 'spoon', 'bowl',
    'banana', 'apple', 'sandwich', 'orange', 'broccoli', 'carrot', 'hot dog', 'pizza',
    'donut', 'cake', 'chair', 'couch', 'potted plant', 'bed', 'N/A', 'dining table',
    'N/A', 'N/A', 'toilet', 'N/A', 'tv', 'laptop', 'mouse', 'remote', 'keyboard', 'cell phone',
    'microwave', 'oven', 'toaster', 'sink', 'refrigerator', 'N/A', 'book',
    'clock', 'vase', 'scissors', 'teddy bear', 'hair drier', 'toothbrush'
]

# this will help us create a different color for each class
COLORS = np.random.uniform(0, 255, size=(len(coco_names), 3))

# define the torchvision image transforms
transform = transforms.Compose([
    transforms.ToTensor(),
])

def predict(image, model, device, detection_threshold):
    # transform the image to tensor
    image = transform(image).to(device)
    image = image.unsqueeze(0) # add a batch dimension
    outputs = model(image) # get the predictions on the image

    print(outputs)
    # print the results individually
    # print(f"BOXES: {outputs[0]['boxes']}")
    # print(f"LABELS: {outputs[0]['labels']}")
    # print(f"SCORES: {outputs[0]['scores']}")
    # get all the predicited class names
    pred_classes = [coco_names[i] for i in outputs[0]['labels'].cpu().numpy()]
    # get score for all the predicted objects
    pred_scores = outputs[0]['scores'].detach().cpu().numpy()
    # get all the predicted bounding boxes
    pred_bboxes = outputs[0]['boxes'].detach().cpu().numpy()
    # get boxes above the threshold score
    boxes = pred_bboxes[pred_scores >= detection_threshold].astype(np.int32)
    return boxes, pred_classes, outputs[0]['labels']


def draw_boxes(boxes, classes, labels, image):
    # read the image with OpenCV
    image = cv2.cvtColor(np.asarray(image), cv2.COLOR_BGR2RGB)
    for i, box in enumerate(boxes):
        color = COLORS[labels[i]]
        cv2.rectangle(
            image,
            (int(box[0]), int(box[1])),
            (int(box[2]), int(box[3])),
            color, 2
        )
        cv2.putText(image, classes[i], (int(box[0]), int(box[1]-5)),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.8, color, 2, 
                    lineType=cv2.LINE_AA)
    return image


def result_fasterrcnn(model, device):
    image = Image.open('tmp/input.jpg')
    model.eval().to(device)
    boxes, classes, labels = predict(image, model, device, 0.8)
    image = draw_boxes(boxes, classes, labels, image)
    #cv2.imshow('Image', image)
    cv2.imwrite(f"tmp/outputs.jpg", image)
    cv2.waitKey(0)


def result_fasterrcnn_video(model, device):
    cap = cv2.VideoCapture('tmp/input.mp4')
    if (cap.isOpened() == False):
        print('Error while trying to read video. Please check path again')
    # get the frame width and height
    frame_width = int(cap.get(3))
    frame_height = int(cap.get(4))
    # define codec and create VideoWriter object 
    out = cv2.VideoWriter(f"tmp/outputs.mp4", 
                        cv2.VideoWriter_fourcc(*'mp4v'), 30, 
                        (frame_width, frame_height))

    frame_count = 0 # to count total frames
    total_fps = 0 # to get the final frames per second
    # load the model onto the computation device
    model = model.eval().to(device)
    # read until end of video
    while(cap.isOpened()):
        # capture each frame of the video
        ret, frame = cap.read()
        if ret == True:
            # get the start time
            start_time = time.time()
            with torch.no_grad():
                # get predictions for the current frame
                boxes, classes, labels = predict(frame, model, device, 0.8)
            
            # draw boxes and show current frame on screen
            image = draw_boxes(boxes, classes, labels, frame)
            # get the end time
            end_time = time.time()
            # get the fps
            fps = 1 / (end_time - start_time)
            # add fps to total fps
            total_fps += fps
            # increment frame count
            frame_count += 1
            # press `q` to exit
            wait_time = max(1, int(fps/4))
            #cv2.imshow('image', image)
            out.write(image)
            if cv2.waitKey(wait_time) & 0xFF == ord('q'):
                break
        else:
            break


def result_keypoint(model):
    IMG_SIZE = 480
    THRESHOLD = 0.95

    #Download Model

    model = torchvision.models.detection.keypointrcnn_resnet50_fpn(pretrained=True).eval()

    #Load Image

    #img = Image.open('imgs/07.jpg')
    file_path = 'tmp/input.jpg'
    img = Image.open(file_path)
    img = img.resize((IMG_SIZE, int(img.height * IMG_SIZE / img.width)))

    plt.figure(figsize=(16, 16))
    plt.imshow(img)

    #Image to Tensor

    trf = transforms.Compose([
        transforms.ToTensor()
    ])

    input_img = trf(img)

    print(input_img.shape)

    #Inference

    out = model([input_img])[0]

    print(out.keys())

    codes = [
        Path.MOVETO,
        Path.LINETO,
        Path.LINETO
    ]

    fig, ax = plt.subplots(1, figsize=(8, 8))
    ax.imshow(img)

    for box, score, keypoints in zip(out['boxes'], out['scores'], out['keypoints']):
        score = score.detach().numpy()

        if score < THRESHOLD:
            continue

        box = box.detach().numpy()
        keypoints = keypoints.detach().numpy()[:, :2]

        rect = patches.Rectangle((box[0], box[1]), box[2]-box[0], box[3]-box[1], linewidth=2, edgecolor='b', facecolor='none')
        ax.add_patch(rect)

        # 17 keypoints
        for k in keypoints:
            circle = patches.Circle((k[0], k[1]), radius=2, facecolor='r')
            ax.add_patch(circle)

        # draw path
        # left arm
        path = Path(keypoints[5:10:2], codes)
        line = patches.PathPatch(path, linewidth=2, facecolor='none', edgecolor='r')
        ax.add_patch(line)

        # right arm
        path = Path(keypoints[6:11:2], codes)
        line = patches.PathPatch(path, linewidth=2, facecolor='none', edgecolor='r')
        ax.add_patch(line)

        # left leg
        path = Path(keypoints[11:16:2], codes)
        line = patches.PathPatch(path, linewidth=2, facecolor='none', edgecolor='r')
        ax.add_patch(line)

        # right leg
        path = Path(keypoints[12:17:2], codes)
        line = patches.PathPatch(path, linewidth=2, facecolor='none', edgecolor='r')
        ax.add_patch(line)

    fig.savefig('tmp/outputs.jpg')


def result_segmentation(model):
    IMG_SIZE = 480

    COLORS = np.array([
        (0, 0, 0),       # 0=background
        (128, 0, 0),     # 1=aeroplane
        (0, 128, 0),     # 2=bicycle
        (128, 128, 0),   # 3=bird
        (0, 0, 128),     # 4=boat
        (128, 0, 128),   # 5=bottle
        (0, 128, 128),   # 6=bus
        (128, 128, 128), # 7=car
        (255, 255, 255), # 8=cat
        (192, 0, 0),     # 9=chair
        (64, 128, 0),    # 10=cow
        (192, 128, 0),   # 11=dining table
        (64, 0, 128),    # 12=dog
        (192, 0, 128),   # 13=horse
        (64, 128, 128),  # 14=motorbike
        (192, 128, 128), # 15=person
        (0, 64, 0),      # 16=potted plant
        (128, 64, 0),    # 17=sheep
        (0, 192, 0),     # 18=sofa
        (128, 192, 0),   # 19=train
        (0, 64, 128)     # 20=tv/monitor
    ])

    #Download Model

    #deeplab = models.segmentation.deeplabv3_resnet101(pretrained=True).eval()

    #Load Image

    #img = Image.open('imgs/03.jpg')
    file_path = 'tmp/input.jpg'
    img = Image.open(file_path)

    plt.figure(figsize=(8, 8))
    plt.imshow(img)

    #Image to Tensor

    trf = transforms.Compose([
        transforms.Resize(IMG_SIZE),
    #     T.CenterCrop(IMG_SIZE), # make square image
        transforms.ToTensor(), 
        transforms.Normalize(
            mean=[0.485, 0.456, 0.406],
            std=[0.229, 0.224, 0.225]
        )
    ])

    input_img = trf(img).unsqueeze(0)

    #Inference

    out = model(input_img)['out']

    print(out.shape)

    #Extract Class Map

    out = torch.argmax(out.squeeze(), dim=0)
    out = out.detach().cpu().numpy()

    print(out.shape)
    print(np.unique(out))

    #Class Map to Segmentation Map

    def seg_map(img, n_classes=21):
        rgb = np.zeros((img.shape[0], img.shape[1], 3), dtype=np.uint8)

        for c in range(n_classes):
            idx = img == c

            rgb[idx] = COLORS[c]

        return rgb

    out_seg = seg_map(out)

    fig, ax = plt.subplots(nrows=1, ncols=2, figsize=(16, 16))
    ax[0].imshow(img)
    ax[1].imshow(out_seg)

    fig.savefig('tmp/outputs.jpg')
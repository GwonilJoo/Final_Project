from utils import *

class SimpleCNN(nn.Module):
    def __init__(self):
        super().__init__()
        # self.conv 구현
        self.conv = nn.Sequential(
            ## 코드 시작 ##
            nn.Conv2d(3,32,kernel_size=3),    # conv_1 해당하는 층
            nn.BatchNorm2d(32),    # batch_norm_1 해당하는 층
            nn.ReLU(),    # ReLU_1 해당하는 층
            nn.MaxPool2d(2),    # maxpool_1 해당하는 층
            
            nn.Conv2d(32,64,kernel_size=3),    # conv_2 해당하는 층
            nn.BatchNorm2d(64),    # batch_norm_2 해당하는 층
            nn.ReLU(),    # ReLU_2 해당하는 층
            nn.MaxPool2d(2),    # maxpool_2 해당하는 층
            
            nn.Conv2d(64,128,kernel_size=3),    # conv_3 해당하는 층
            nn.BatchNorm2d(128),    # batch_norm_3 해당하는 층 
            nn.ReLU(),    # ReLU_3 해당하는 층
            nn.MaxPool2d(2),    # maxpool_3 해당하는 층
            
            nn.Conv2d(128,128,kernel_size=3),    # conv_4 해당하는 층
            nn.BatchNorm2d(128),    # batch_norm_4 해당하는 층
            nn.ReLU(),    # ReLU_4 해당하는 층
            nn.MaxPool2d(2),    # maxpool_4 해당하는 층
            ## 코드 종료 ##
        )
        
        # self.fc 구현
        ## 코드 시작 ##
        self.fc1 = nn.Linear(128*5*5, 512)
        self.fc2 = nn.Linear(512, 2)
        ## 코드 종료 ##
    
    def forward(self, x):
        x = self.conv(x)
        x = x.view(x.shape[0], -1)
        x = F.relu(self.fc1(x))
        x = self.fc2(x)
        return x


def resnet(num_classes):
    model = torchvision.models.resnet18(pretrained=True)
    num_ftrs = model.fc.in_features
    model.fc = nn.Linear(num_ftrs, num_classes)

    return model


def faster_rcnn():
    model = torchvision.models.detection.fasterrcnn_resnet50_fpn(pretrained=True, 
                                                    min_size=480)
    return model

def keypoint():
    model = torchvision.models.detection.keypointrcnn_resnet50_fpn(pretrained=True).eval()
    return model

def segmentation():
    model = torchvision.models.segmentation.deeplabv3_resnet101(pretrained=True).eval()
    return model
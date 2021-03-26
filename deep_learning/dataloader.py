from utils import *

class CatDogDataset(Dataset):
    def __init__(self, data_dir, mode, transform=None):
        self.all_data = sorted(glob.glob(os.path.join(data_dir, mode, '*', '*')))
        self.transform = transform
    
    def __getitem__(self, index):
        data_path = self.all_data[index] 
        img = Image.open(data_path)         
        if self.transform != None:
          img = self.transform(img)            

        label = int(os.path.basename(data_path).startswith('dog'))
        return img, label
    
    def __len__(self):
        length = len(self.all_data)
        return length


data_transforms = {
    'train': transforms.Compose([
        transforms.RandomRotation(5),
        transforms.RandomHorizontalFlip(),
        transforms.RandomResizedCrop(120, scale=(0.96, 1.0), ratio=(0.95, 1.05)),
        transforms.ToTensor(),
        transforms.Normalize([0.485, 0.456, 0.406], [0.229, 0.224, 0.225])
    ]),
    'val': transforms.Compose([
        transforms.Resize([120, 120]),
        transforms.ToTensor(),
        transforms.Normalize([0.485, 0.456, 0.406], [0.229, 0.224, 0.225])
    ]),
}
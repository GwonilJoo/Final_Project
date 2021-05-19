from utils import *
import os

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


def Train_loader(data_dir, batch_size):
    train_dir = os.path.join(data_dir, 'train')
    dataset = ImageFolder(root=train_dir, transform=data_transforms['train'])
    dataloader = DataLoader(dataset, batch_size=batch_size, shuffle=True, drop_last=False)

    class_names = tuple([name for name, label in dataset.class_to_idx.items()])

    return class_names, dataloader


def Valid_loader(data_dir, batch_size):
    val_dir = os.path.join(data_dir, 'val')
    if os.path.isdir(val_dir) == False:
        val_dir = os.path.join(data_dir, 'test')

    dataset = ImageFolder(root=val_dir, transform=data_transforms['test'])
    dataloader = DataLoader(dataset, batch_size=batch_size, shuffle=False, drop_last=False)

    class_names = tuple([name for name, label in dataset.class_to_idx.items()])

    return class_names, dataloader



def Test_loader(data_dir, batch_size):
    test_dir = os.path.join(data_dir, 'test')
    dataset = ImageFolder(root=test_dir, transform=data_transforms['test'])
    dataloader = DataLoader(dataset, batch_size=batch_size, shuffle=False, drop_last=False)

    class_names = tuple([name for name, label in dataset.class_to_idx.items()])

    return class_names, dataloader


data_transforms = {
    'train': transforms.Compose([
        transforms.Resize([224,224]),
        transforms.RandomRotation(5),
        transforms.RandomHorizontalFlip(),
        transforms.RandomResizedCrop(120, scale=(0.96, 1.0), ratio=(0.95, 1.05)),
        transforms.ToTensor(),
        transforms.Normalize([0.485, 0.456, 0.406], [0.229, 0.224, 0.225])
    ]),
    'test': transforms.Compose([
        transforms.Resize([224,224]),
        transforms.ToTensor(),
        transforms.Normalize([0.485, 0.456, 0.406], [0.229, 0.224, 0.225])
    ]),
}


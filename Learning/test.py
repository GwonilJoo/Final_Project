from dataloader import *
from model import *

parser = argparse.ArgumentParser(description='cls')
parser.add_argument('--batch_size', type=int, default=100)
parser.add_argument('--data_dir', type=str, default='../dataset/gwonil/my_cat_dog')
parser.add_argument('--model_path', type=str, default='../dataset/gwonil/my_cat_dog/saved/best_model.pt')
parser.add_argument('--random_seed', type=int, default='222')
args = parser.parse_args()


def test(model, data_loader, device):
    print('Start test..')
    model.eval()
    with torch.no_grad():
        correct = 0
        total = 0
        for i, (imgs, labels) in enumerate(data_loader):
            imgs, labels = imgs.to(device), labels.to(device)
            outputs = model(imgs)
            _, argmax = torch.max(outputs, 1)
            total += imgs.size(0)
            correct += (labels == argmax).sum().item()

        print('Test accuracy for {} images: {:.2f}%'.format(total, correct / total * 100))
    model.train()


def main():
    device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
    print(device)

    # dataset
    test_data = CatDogDataset(data_dir=args.data_dir, mode='test', transform=data_transforms['val'])
    
    # dataloader
    test_loader = DataLoader(test_data, batch_size=args.batch_size, shuffle=False, drop_last=True)
    
    # model
    model = SimpleCNN().to(device)

    checkpoint = torch.load(args.model_path)
    state_dict = checkpoint['net']
    model.load_state_dict(state_dict)

    test(model, test_loader, device)


if __name__ == "__main__":
    main()
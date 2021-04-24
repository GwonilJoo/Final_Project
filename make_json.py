import json

file_path = "./sample.json"

# data = {}
# data['loss'] = []
# data['loss'].append(0.9)
# data['loss'].append(0.1)
# data['loss'].append(0.05)
# data['loss'].append(0.01)
#
# data['iter'] = [1,2,3,4]

data = [[1,0.9], [2,0.1], [3,0.05], [4,0.9]]

print(data)

with open(file_path, 'w') as outfile:
    json.dump(data, outfile)

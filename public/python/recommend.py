from flask import Flask, jsonify, request
import pickle
import os
import pandas as pd
import sys

app = Flask(__name__)

current_directory = os.path.dirname(os.path.realpath(__file__))
garage_path = os.path.join(current_directory, 'garage_1.pkl')
similary_path = os.path.join(current_directory, 'similarity_1.pkl')
df_garage = pickle.load(open(garage_path, "rb"))
garages = pd.DataFrame(df_garage)
similarity = pickle.load(open(similary_path, "rb"))

@app.route('/api/recommend-garage/<int:id>', methods=['GET'])
def get_recommendation(id):
    gara_index = garages[garages['id_garage'] == id].index[0]
    
    distances = similarity[gara_index]
    
    gara_list = sorted(list(enumerate(distances)), reverse=True, key=lambda x: x[1])[1:9]

    data_recommend = []
    for i in gara_list:
        data_recommend.append(int(garages.iloc[i[0]]['id_garage']))
    print(data_recommend)
    
    if data_recommend:
        return jsonify(data_recommend)
    else:
        return jsonify({'message': 'not found'}), 404

if __name__ == '__main__':
    app.run(debug=True)

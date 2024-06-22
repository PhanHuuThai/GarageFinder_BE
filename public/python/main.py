import pickle
import os
import pandas as pd
import sys

v = sys.argv[1]

def recommendation(id_gara):
    gara_index = garages[garages['id_garage'] == int(id_gara)].index[0]
    distances = similarity[gara_index]
    gara_list = sorted(list(enumerate(distances)), reverse=True, key=lambda x: x[1])[1:9]

    data_recommend = []
    for i in gara_list:
        data_recommend.append(garages.iloc[i[0]]['id_garage'])
    print(data_recommend)
current_directory = os.path.dirname(os.path.realpath(__file__))
garage_path = os.path.join(current_directory, 'garage.pkl')
similary_path = os.path.join(current_directory, 'similarity.pkl')
df_garage = pickle.load(open(garage_path, "rb"))
garages = pd.DataFrame(df_garage)
similarity = pickle.load(open(similary_path, "rb"))

recommendation(v)

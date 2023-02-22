
import sys
sys.path.insert(0, "/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/core")

from sentence_transformers import SentenceTransformer, util
sentenceTransformerModel = SentenceTransformer('all-MiniLM-L6-v2')

import nltk
nltk.download('punkt')

import os

from PyPDF2 import PdfReader
import numpy as np
import time
import asyncio
import sys
import argparse
import json
import requests
import translator as translator
import data_preprocessor as data_preprocessor
import mailing as mailing

APP_BASE_PATH = '/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector'
AI_CORE_BASE_PATH = APP_BASE_PATH + '/ai-core'
DATABASE_FOLDER_PATH = AI_CORE_BASE_PATH + '/database'
UPDATE_ANALYSIS_RESULTS_API = 'http://localhost:8000/api/v1/update-analysis-result'

new_file_path = None
original_text = None
rewritten_text = None
new_doc_sentences_plagiarism_score = []
tasks = []
new_doc_sentences = []
new_doc_file_path = DATABASE_FOLDER_PATH + '/new_docs_temp_folder/new-doc.pdf'
analysis_item_id = None

def save_plagiarism_result_on_backend_database(analysis_results):
    global analysis_item_id
    headers = {'Content-type': 'application/json'}
    response = requests.post(UPDATE_ANALYSIS_RESULTS_API, 
                             json={
                                 'analysis_results': str(analysis_results), 
                                 'analysis_item_id': analysis_item_id
                                }, 
                             headers=headers)
    print(response.json())

    return response

def get_file_text(file_path: str):
    reader = PdfReader(str(file_path))
    number_of_pages = len(reader.pages)
    page = reader.pages
    text = ""
    print("Lecture du document : " + file_path + ". Nb pages: "+ str(number_of_pages) + ".")
    for page in reader.pages:
        text = text + ". " + data_preprocessor.preprocess_text(page.extract_text())

    return text

def get_database_files_list():
    # iterator of os.DirEntry objects
    obj = os.scandir(DATABASE_FOLDER_PATH + '/cache2')

    #liste des fichiers
    files_list = []

    # List all files and directories
    print("Files and Directories in '% s':" % DATABASE_FOLDER_PATH + '/cache2')
    for entry in obj :
        if entry.is_file() and entry.name.endswith(('.pdf','.PDF')):
            files_list.append(entry.path)

    # To Close the iterator
    obj.close()

    return files_list

#retourne la lists des phrases dans un text sous forme de list
def sent_tokenize(sentences: str) -> list:
    result = nltk.sent_tokenize(sentences)
    r = []
    if result != None:
        #r = [translator.translate_text(sentence) for sentence in result]
        r = [sentence for sentence in result]
    return r

#fonction d'analyse de la similarité qui retourne une list contenant les phrases qui ont un score de plagiat élevé
async def analyze_similarity_between_sentences(document1_sentences: list, document2_sentences: list, threshold = 0.8) -> list:
    result = []

    sentences = document1_sentences + document2_sentences
    #print(sentences)
    doc1_len = len(document1_sentences)
     
    #paraphrases = await asyncio.get_event_loop().run_in_executor(None, util.paraphrase_mining, sentenceTransformerModel, sentences)
    paraphrases = util.paraphrase_mining(sentenceTransformerModel, sentences, show_progress_bar=False)

    k = 0
    loop_stop = 1.0
    sentence_min_len = 50
    while loop_stop >= threshold and k < len(paraphrases):
        score, i, j = paraphrases[k]
        if (score >= threshold and ((i < doc1_len and j >= doc1_len) or (i >= doc1_len and j < doc1_len)) and len(sentences[i]) > sentence_min_len and len(sentences[j]) > sentence_min_len):
            result.append([sentences[i], sentences[j], score])
        k = k + 1
        loop_stop = score
    #print(result)
    return result

def save_sentences_and_scores(save_list: list, result: list):
    save_list.append(result)
    """for e in save_list :
        if (len(save_list) <= 2):
            print('')
        elif (e[0] == result[0] and e[1] == result[1]):
            if(e[2] < result[2]):
                e[2] = result[2]
        else:
            save_list.append(result)"""

def get_plagiarism_rate(new_doc_nbr_pages_or_text_sentences_len: int, save_list: list) -> float:
    #score_total = 0
    #print("Save list:")
    #print(str(len(save_list[0])))
    #print(new_doc_nbr_pages_or_text_sentences_len)
    #print(save_list)
    return float(len(save_list[0]) / new_doc_nbr_pages_or_text_sentences_len)

async def check_plagiarism_between_newdoc_and_file(new_doc_sentences: list, database_file_path: str):
    global new_doc_sentences_plagiarism_score
    database_file_text = get_file_text(database_file_path)
    database_file_text_sentences = sent_tokenize(database_file_text)
    result = await analyze_similarity_between_sentences(new_doc_sentences, database_file_text_sentences)
    save_sentences_and_scores(new_doc_sentences_plagiarism_score, result)

async def check_plagiarism_between_text(original_text: str, rewritten_text: str):
    global new_doc_sentences_plagiarism_score
    original_text_sentences = sent_tokenize(original_text)
    rewritten_text_sentences = sent_tokenize(rewritten_text)
    result = await analyze_similarity_between_sentences(rewritten_text_sentences, original_text_sentences)
    save_sentences_and_scores(new_doc_sentences_plagiarism_score, result)

async def check_new_doc_plagirism_score():
    global new_doc_sentences_plagiarism_score
    global tasks
    global new_doc_file_path
    global new_doc_sentences
    global new_file_path
    global original_text
    global rewritten_text
    tasks = []
    new_doc_sentences_plagiarism_score = []
    database_files_path = get_database_files_list()
    new_doc_text = None
    if(rewritten_text == None):
        new_doc_text = get_file_text(new_doc_file_path)
        new_doc_sentences = sent_tokenize(new_doc_text)
        for file_path in database_files_path:
            task = asyncio.create_task(check_plagiarism_between_newdoc_and_file(new_doc_sentences, file_path))
            tasks.append(task)
    else:
        tasks.append(asyncio.create_task(check_plagiarism_between_text(rewritten_text, original_text)))
    
    await asyncio.gather(*tasks)

parser = argparse.ArgumentParser(description="Commands to check plagiarism with our engine")
#parser.add_argument('--lang', dest='lang', type=str, help='Source Lang')
parser.add_argument('--f', dest='new_file_path', type=str, help='Your new file path')
parser.add_argument('--original_text', dest='original_text', type=str, help='Original text')
parser.add_argument('--rewritten_text', dest='rewritten_text', type=str, help='Rewritten text')
parser.add_argument('--analysis_item_id', dest='analysis_item_id', type=str, help='Analysis item identifier')

def main(newFilePath, originalText, rewrittenText, analysisItemId):
    t1 = time.perf_counter()
    global new_doc_file_path
    global new_file_path
    global original_text
    global rewritten_text
    global analysis_item_id
    new_file_path = newFilePath
    original_text = originalText
    rewritten_text = rewrittenText
    analysis_item_id = analysisItemId
    
    if(new_file_path == None and original_text == None and rewritten_text == None):
        print("Veuillez ajouter le chemin vers un nouveau fichier")
    else:
        result = None
        if (original_text == None or rewritten_text == None):
            new_doc_file_path = new_file_path
            asyncio.run(check_new_doc_plagirism_score())
            result = get_plagiarism_rate(len(new_doc_sentences), new_doc_sentences_plagiarism_score)
            #print(check_new_doc_plagirism_score_result)
        else:
            asyncio.run(check_new_doc_plagirism_score())
            #asyncio.run(analyze_similarity_between_sentences(sent_tokenize(original_text), sent_tokenize(rewritten_text)))
            result = get_plagiarism_rate(len(sent_tokenize(rewritten_text)), new_doc_sentences_plagiarism_score)
        print(f"Le taux de plagiat est de {result}")

    t2 = time.perf_counter()
    print(f'Temps d exécution du programme : {t2-t1:0.6f} secondes')
    
    save_plagiarism_result_on_backend_database(result)
    #mailing.send_result_to_user_by_mail(result)
    return result

if __name__ == "__main__":
    t1 = time.perf_counter()
    args = parser.parse_args()
    main(args.new_file_path, args.original_text, args.rewritten_text, args.analysis_item_id)
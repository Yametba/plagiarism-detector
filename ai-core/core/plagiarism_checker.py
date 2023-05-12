
import sys
import os

from sentence_transformers import SentenceTransformer, util

#import nltk
#nltk.download('punkt')

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
import files_reader as files_reader

APP_BASE_PATH = os.path.dirname(os.path.abspath(__file__)) + '/../..'

#Inserts a new path in the sys.path list of the sys module, which is used to search for imported modules in a Python program
sys.path.insert(0, APP_BASE_PATH + '/ai-core/core')

sentenceTransformerModel = SentenceTransformer('all-MiniLM-L6-v2')

#Load .env file for the main projet
ENV_PATH = APP_BASE_PATH + '/.env'
#load_dotenv(dotenv_path=ENV_PATH)
APP_URL = "http://localhost:8000" #str(os.getenv("APP_URL")) #

AI_CORE_BASE_PATH = APP_BASE_PATH + '/ai-core'
DATABASE_FOLDER_PATH = APP_BASE_PATH + '/storage/app/public/database/cache2'
UPDATE_ANALYSIS_RESULTS_API = APP_URL + '/api/v1/update-analysis-result'

#print("DATABASE_FOLDER_PATH :" + DATABASE_FOLDER_PATH)

new_file_path = None
original_text = None
rewritten_text = None
new_doc_sentences_plagiarism_score = []
tasks = []
new_doc_sentences = []
new_doc_file_path = None
analysis_item_id = None

def save_plagiarism_result_on_backend_database(analysis_results):
    global analysis_item_id
    headers = {'Content-type': 'application/json'}
    response = requests.post(UPDATE_ANALYSIS_RESULTS_API, 
                             json={
                                 'analysis_results': json.dumps(analysis_results), 
                                 'analysis_item_id': analysis_item_id
                                }, 
                             headers=headers)
    #print(response.content)
    return response

def get_file_text(file_path: str):
    file_type = files_reader.determine_file_type(file_path)
    text = ""
    if file_type == 'PDF':
        text = files_reader.read_pdf_text(file_path)
        #print(text)
    elif file_type == 'WORD' :
        #
         text = files_reader.read_word_file(file_path)
    else:
        text = ''
        
    return text

def get_database_files_list():
    # iterator of os.DirEntry objects
    obj = os.scandir(DATABASE_FOLDER_PATH)

    #liste des fichiers
    files_list = []

    # List all files and directories
    print("Files and Directories in '% s':" % DATABASE_FOLDER_PATH)
    for entry in obj :
        if entry.is_file() and entry.name.endswith(('.pdf','.PDF')):
            files_list.append(entry.path)

    # To Close the iterator
    obj.close()

    return files_list

#retourne la lists des phrases dans un text sous forme de list
def sent_tokenize(sentences: str) -> list:
    result = data_preprocessor.sent_tokenize(sentences)
    s = []
    if result != None:
        #s = [translator.translate_text(sentence) for sentence in result]
        #print(s)
        s = [sentence for sentence in result]
    return s

#fonction d'analyse de la similarité qui retourne une list contenant les phrases qui ont un score de plagiat élevé
async def analyze_similarity_between_sentences(document1_sentences: list, document2_sentences: list, document1_name: str, document2_name: str, threshold = 0.8) -> list:
    result = []

    sentences = document1_sentences + document2_sentences
    #print(sentences)
    doc1_len = len(document1_sentences)
     
    #paraphrases = await asyncio.get_event_loop().run_in_executor(None, util.paraphrase_mining, sentenceTransformerModel, sentences)
    paraphrases = util.paraphrase_mining(sentenceTransformerModel, sentences, show_progress_bar=False)

    k = 0
    loop_stop = 1.0
    #sentence_min_len pour éviter de prendre en compte les phrases trop courtes
    #sentence_min_len = 50
    while loop_stop >= threshold and k < len(paraphrases):
        score, i, j = paraphrases[k]
        #if (score >= threshold and ((i < doc1_len and j >= doc1_len) or (i >= doc1_len and j < doc1_len)) and len(sentences[i]) > sentence_min_len and len(sentences[j]) > sentence_min_len):
        if (score >= threshold and ((i < doc1_len and j >= doc1_len) or (i >= doc1_len and j < doc1_len))):
            result.append([sentences[i], sentences[j], score, document1_name, document2_name])
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
    print(str(len(save_list[0])))
    print(new_doc_nbr_pages_or_text_sentences_len)
    print(save_list)
    return [float(len(save_list[0]) / new_doc_nbr_pages_or_text_sentences_len), save_list[0]]

async def check_plagiarism_between_newdoc_and_file(new_doc_sentences: list, database_file_path: str):
    global new_doc_sentences_plagiarism_score
    global new_doc_file_path
    database_file_text = get_file_text(database_file_path)
    database_file_text_sentences = sent_tokenize(database_file_text)
    result = await analyze_similarity_between_sentences(new_doc_sentences, database_file_text_sentences, str(new_doc_file_path), str(database_file_path))
    save_sentences_and_scores(new_doc_sentences_plagiarism_score, result)

async def check_plagiarism_between_text(original_text: str, rewritten_text: str):
    global new_doc_sentences_plagiarism_score
    original_text_sentences = sent_tokenize(original_text)
    rewritten_text_sentences = sent_tokenize(rewritten_text)
    result = await analyze_similarity_between_sentences(rewritten_text_sentences, original_text_sentences, 'rewritten_text', 'original_text')
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
    
    print(result)
    save_plagiarism_result_on_backend_database(result)
    #mailing.send_result_to_user_by_mail(result)
    return result

if __name__ == "__main__":
    t1 = time.perf_counter()
    args = parser.parse_args()
    main(args.new_file_path, args.original_text, args.rewritten_text, args.analysis_item_id)
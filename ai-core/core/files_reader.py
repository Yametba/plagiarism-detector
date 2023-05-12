import os
import mimetypes
import docx
from PyPDF2 import PdfReader
import numpy as np
import translator as translator
import data_preprocessor as data_preprocessor
from pathlib import Path
import sys
path_root = Path(__file__).parents[2]
sys.path.append(str(path_root))

def determine_file_type(file_path):
    """
    Détermine le type de fichier en utilisant son extension et son contenu.
    Retourne l'extension du fichier si elle est connue, sinon "UNKNOWN".
    """
    # Obtenir l'extension du fichier à partir de son chemin d'accès
    extension = os.path.splitext(file_path)[1][1:].lower()
    
    # Déterminer le type de fichier en fonction de son extension
    if extension == 'docx':
        return 'WORD'
    elif extension == 'pdf':
        return 'PDF'
    else:
        # Déterminer le type de fichier en fonction de son contenu
        mime_type, _ = mimetypes.guess_type(file_path)
        if mime_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return 'WORD'
        elif mime_type == 'application/pdf':
            return 'PDF'
        else:
            # Si le type de fichier ne peut pas être déterminé
            return 'UNKNOWN'

def read_pdf_text(file_path):
    reader = PdfReader(str(file_path))
    number_of_pages = len(reader.pages)
    page = reader.pages
    text = ''
    print("Lecture du document : " + file_path + ". Nb pages: "+ str(number_of_pages) + ".")
    for page in reader.pages:
        val = data_preprocessor.preprocess_text_with_regex(page.extract_text())
        text = text + " " + val
            
    #print(text)
    return text

def read_word_file(file_path):
    """
    Ouvre un fichier Word en utilisant la bibliothèque python-docx
    et retourne le texte brut qui y est contenu.
    """
    # Créer un objet docx.Document pour le fichier Word
    doc = docx.Document(file_path)
    
    # Extraire le texte brut à partir de chaque paragraphe
    text = ''
    for paragraph in doc.paragraphs:
        val = data_preprocessor.preprocess_text_with_regex(paragraph.text)
        text += val
        #if len(val) >= 50:
        #    text += val
            
    return text
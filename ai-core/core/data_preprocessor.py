import re
import string
import nltk
import os
from nltk.tokenize import sent_tokenize, word_tokenize
from nltk.corpus import stopwords
from nltk.stem import SnowballStemmer, WordNetLemmatizer
from langdetect import detect

nltk.download('punkt')
nltk.download('stopwords')

APP_BASE_PATH = os.path.dirname(os.path.abspath(__file__)) + '/../..'

def sent_tokenize(text, language="english"):
    return nltk.sent_tokenize(text)

def extract_well_formed_sentences(text):
    # Utilisation de la tokenization de phrases de NLTK pour extraire les phrases
    sentences = nltk.sent_tokenize(text)

    # Vérification de la validité de chaque phrase
    well_formed_sentences = []
    for sentence in sentences:
        if is_well_formed(sentence):
            well_formed_sentences.append(sentence)

    return well_formed_sentences

def is_well_formed(sentence):
    # Vérifie si une phrase est bien formée selon un critère quelconque
    # Dans cet exemple, nous vérifions simplement si la phrase commence par une majuscule et se termine par un point.
    if sentence[0].isupper() and sentence[-1] == '.':
        return True
    return False

def generate_new_text(sentences):
    # Génère un nouveau texte à partir des phrases bien formées
    new_text = ' '.join(sentences)
    return new_text

def preprocess_text(text):
    # Exemple d'utilisation
    #text = "Ceci est une phrase bien formée. Voici une autre phrase bien formée. Cette phrase ne l'est pas"
    well_formed_sentences = extract_well_formed_sentences(text)
    new_text = generate_new_text(well_formed_sentences)
    #print(new_text)
    return new_text

def preprocess_text_with_nltk(text):
    # Détection automatique de la langue
    language = detect(text)
    
    if language == 'fr':
        l = 'french'
    elif language == 'en':
        l = 'english'
    else:
        return 'english'
        
    # Tokenizer le texte en phrases
    sentences = nltk.sent_tokenize(text)
    
    # Prétraiter chaque phrase individuellement
    preprocessed_sentences = []
    for sentence in sentences:
        # Convertir la phrase en minuscules
        sentence = sentence.lower()
        
        # Retirer les sauts de ligne, les tabulations et les retours chariots
        sentence = re.sub(r'\s+', ' ', sentence)
        
        # Retirer la ponctuationw
        sentence_no_punct = sentence.translate(str.maketrans("", "", string.punctuation))
        
        # Retirer les chiffres
        sentence_no_punct = re.sub(r'\d+', '', sentence_no_punct)
        
        # Tokenizer la phrase en mots
        tokens = nltk.word_tokenize(sentence_no_punct, language=l)
        
        # Retirer les mots vides en fonction de la langue détectée
        if language == 'en':
            stop_words = set(stopwords.words('english'))
        elif language == 'fr':
            stop_words = set(stopwords.words('french'))
        else:
            stop_words = set()
            
        tokens = [token for token in tokens if token not in stop_words]
        
        # Rejoindre les mots de la phrase avec les ponctuations initiales
        preprocessed_sentence = ''
        idx = 0
        for i, token in enumerate(tokens):
            while idx < len(sentence):
                if sentence[idx].isalpha() or sentence[idx].isspace():
                    preprocessed_sentence += token + sentence[idx]
                    idx += 1
                    break
                else:
                    preprocessed_sentence += sentence[idx]
                    idx += 1
        
        preprocessed_sentences.append(preprocessed_sentence)
    
    # Rejoindre les phrases prétraitées en un seul texte
    preprocessed_text = '. '.join(preprocessed_sentences)
    
    return preprocessed_text

def remove_sentences_with_footnotes_and_paraphrases(text):
    # Divisez le texte en phrases en utilisant un point suivi d'un espace ou d'un retour à la ligne comme délimiteur
    sentences = re.split(r'[.\n]', text)
    
    # Bouclez sur les phrases et les ajoutez à la nouvelle liste uniquement si elles ne contiennent pas de références de paraphrase (entre crochets) ou de notes de bas de page (entre parenthèses)
    new_sentences = [sentence for sentence in sentences if not re.search(r'\[.*?\]', sentence) and not re.search(r'\(.*?\)', sentence)]
    
    # Rejoignez les phrases en une seule chaîne de caractères en utilisant des points suivis d'un espace comme délimiteur
    new_text = ". ".join(new_sentences) + "."
    
    return new_text

#Supprime les phrases courtes dans le text (Mois de 'min_word_nbr' dans le text)
def remove_short_sentences(text, min_word_nbr=5):
    # Divise le texte en phrases
    sentences = re.split(r'(?<!\w\.\w.)(?<![A-Z][a-z]\.)(?<=\.|\?)\s', text)
    # Supprime les phrases courtes
    filtered_sentences = [s for s in sentences if len(s.split()) >= min_word_nbr]
    # Reconstitue le texte à partir des phrases filtrées
    filtered_text = ' '.join(filtered_sentences)
    return filtered_text

def preprocess_text_with_regex(text):
    # Nettoyage du texte en retirant les éléments indésirables
    text = re.sub(r'\n', ' ', text)  # Remplacement des retours à la ligne par des espaces
    text = re.sub(r'\s+', ' ', text)  # Remplacement des espaces multiples par un seul espace
    text = re.sub(r'\x0c', '', text)  # Retrait des caractères de contrôle
    text = remove_short_sentences(text)
    
    text = text.replace("\n", " ")
    
    text = re.sub(r'(?<!\w\.\w.)(?<![A-Z][a-z]\.)(?<=\.|\?)\s', '', text) # Supprimer les points qui ne sont pas des points de fin de phrase
    
    #text = remove_sentences_with_footnotes_and_paraphrases(text)
    result = text
    return result

def clean_text(text):
    # Retirer les sauts de ligne, les tabulations et les retours chariots
    text = re.sub(r'\s+', ' ', text)
    
    # Retirer la ponctuation
    #text = text.translate(str.maketrans("", "", string.punctuation))
    
    # Retirer les nombres
    text = re.sub(r'\d+', '', text)
    
    # Convertir le texte en minuscules
    # text = text.lower()
    
    # Retirer les espaces 
    # en début et fin de texte
    text = text.strip()
    
    # Séparer le texte en phrases
    sentences = re.split('[.!?]', text)
    
    # Retirer les phrases vides
    sentences = [sentence for sentence in sentences if sentence.strip() != '']
    
    # Ajouter des points à la fin de chaque phrase
    cleaned_sentences = [sentence.strip() + '.' for sentence in sentences]
    
    # Concaténer les phrases nettoyées en un seul texte
    cleaned_text = ' '.join(cleaned_sentences)
    
    # Retourner le texte nettoyé
    return cleaned_text

def exceeds_five_words(sentence):
    words = sentence.split()  # Split the sentence into words using spaces as the delimiter
    word_count = len(words)  # Count the number of words in the sentence
    
    if word_count > 5:
        return True
    else:
        return False

# Appliquer le prétraitement à un texte d'entrée
"""input_text = "This is an example of text preprocessing before submitting it to / // a plagiarism detection system."
preprocessed_text = preprocess_text(input_text)
print(preprocessed_text)"""

import re
import string
import nltk
#from nltk.tokenize import sent_tokenize
from nltk.corpus import stopwords
from nltk.stem import SnowballStemmer, WordNetLemmatizer
from langdetect import detect

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

"""def preprocess_text(text):
    # Nettoyage du texte en retirant les éléments indésirables
    text = re.sub(r'\n', ' ', text)  # Remplacement des retours à la ligne par des espaces
    text = re.sub(r'\s+', ' ', text)  # Remplacement des espaces multiples par un seul espace
    text = re.sub(r'\x0c', '', text)  # Retrait des caractères de contrôle
    text = remove_short_sentences(text)
    
    text = text.replace("\n", ".")
    text = remove_sentences_with_footnotes_and_paraphrases(text)
    result = text
    return result"""

def preprocess_text(text):
    # Détection automatique de la langue
    language = detect(text)
    
    # Tokenizer le texte en phrases
    sentences = nltk.sent_tokenize(text)
    
    # Prétraiter chaque phrase individuellement
    preprocessed_sentences = []
    for sentence in sentences:
        # Convertir la phrase en minuscules
        sentence = sentence.lower()
        
        # Retirer les sauts de ligne, les tabulations et les retours chariots
        sentence = re.sub(r'\s+', ' ', sentence)
        
        # Retirer la ponctuation
        sentence_no_punct = sentence.translate(str.maketrans("", "", string.punctuation))
        
        # Retirer les chiffres
        sentence_no_punct = re.sub(r'\d+', '', sentence_no_punct)
        
        # Tokenizer la phrase en mots
        tokens = nltk.word_tokenize(sentence_no_punct, language=language)
        
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
    preprocessed_text = ' '.join(preprocessed_sentences)
    
    return preprocessed_text


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


def clean_text_with_nltk(text):
    # Tokenizer le texte en phrases
    sentences = nltk.sent_tokenize(text)
    
    # Charger les ensembles de mots vides pour l'anglais et le français
    english_stopwords = set(stopwords.words('english'))
    french_stopwords = set(stopwords.words('french'))
    
    # Initialiser le stemmer de neige pour le français et l'anglais
    english_stemmer = SnowballStemmer('english')
    french_stemmer = SnowballStemmer('french')
    
    cleaned_sentences = []
    for sentence in sentences:
        # Convertir la phrase en minuscules
        sentence = sentence.lower()
        
        # Supprimer la ponctuation
        sentence = sentence.translate(str.maketrans("", "", string.punctuation))
        
        # Tokenizer la phrase en mots
        words = nltk.word_tokenize(sentence)
        
        # Retirer les mots vides pour l'anglais et le français
        words = [word for word in words if word not in english_stopwords and word not in french_stopwords]
        
        # Lématiser les mots en fonction de la langue
        if detect(text) == 'fr':
            words = [french_stemmer.stem(word) for word in words]
        else:
            words = [english_stemmer.stem(word) for word in words]
        
        # Reconstruire la phrase à partir des mots restants
        cleaned_sentence = " ".join(words)
        cleaned_sentences.append(cleaned_sentence)
    
    # Concaténer les phrases en un seul texte
    cleaned_text = " ".join(cleaned_sentences)
    
    return cleaned_text


# Appliquer le prétraitement à un texte d'entrée
"""input_text = "This is an example of text preprocessing before submitting it to / // a plagiarism detection system."
preprocessed_text = preprocess_text(input_text)
print(preprocessed_text)"""

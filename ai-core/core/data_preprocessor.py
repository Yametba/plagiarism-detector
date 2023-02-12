import nltk
import re

def remove_sentences_with_footnotes_and_paraphrases(text):
    # Divisez le texte en phrases en utilisant un point suivi d'un espace ou d'un retour à la ligne comme délimiteur
    sentences = re.split(r'[.\n]', text)
    
    # Bouclez sur les phrases et les ajoutez à la nouvelle liste uniquement si elles ne contiennent pas de références de paraphrase (entre crochets) ou de notes de bas de page (entre parenthèses)
    new_sentences = [sentence for sentence in sentences if not re.search(r'\[.*?\]', sentence) and not re.search(r'\(.*?\)', sentence)]
    
    # Rejoignez les phrases en une seule chaîne de caractères en utilisant des points suivis d'un espace comme délimiteur
    new_text = ". ".join(new_sentences) + "."
    
    return new_text

def preprocess_text(text):
    # Convertir le texte en minuscules
    #text = text.lower()
    # Supprimer les caractères non alphanumériques
    #text = re.sub(r'[^a-z0-9]', ' ', text)
    # Tokenizer le texte
    #tokens = nltk.word_tokenize(text)
    # Supprimer les mots courants (stopwords)
    #stopwords = nltk.corpus.stopwords.words('english')
    #tokens = [token for token in tokens if token not in stopwords]
    # Retourner le texte prétraité
    #result = ' '.join(tokens)
    text = text.replace("\n", ".")
    text = remove_sentences_with_footnotes_and_paraphrases(text)
    result = text
    return result

# Appliquer le prétraitement à un texte d'entrée
"""input_text = "This is an example of text preprocessing before submitting it to / // a plagiarism detection system."
preprocessed_text = preprocess_text(input_text)
print(preprocessed_text)"""

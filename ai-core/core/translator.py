from pathlib import Path
import sys
path_root = Path(__file__).parents[2]
sys.path.append(str(path_root))

"""
https://huggingface.co/docs/transformers/model_doc/marian
"""

from transformers import MarianMTModel, MarianTokenizer

from langdetect import detect, DetectorFactory
DetectorFactory.seed = 0
import torch

max_new_tokens = 128

def detect_language(text):
    return detect(text)

def translate_text(text, text_lang='fr', target_lang='en') -> str:
    global max_new_tokens

    # Get the name of the model
    model_name = f"Helsinki-NLP/opus-mt-{text_lang}-{target_lang}"

    # Get the tokenizer
    tokenizer = MarianTokenizer.from_pretrained(model_name)

    # Instantiate the model
    model = MarianMTModel.from_pretrained(model_name)

    # Translation of the text
    formated_text = ">>{}<< {}".format(text_lang, text[:max_new_tokens-1])

    #translation = model.generate(**tokenizer([formated_text], return_tensors="pt", padding=True), max_length=128)
    translation = model.generate(**tokenizer([formated_text], return_tensors="pt", padding=True), max_new_tokens=max_new_tokens)

    translated_text = [tokenizer.decode(t, skip_special_tokens=True) for t in translation][0]

    return translated_text

"""
def translate_text(text, text_lang, target_lang='en'):
    # Get the name of the model
    model_name = f"Helsinki-NLP/opus-mt-{text_lang}-{target_lang}"
    # Get the tokenizer
    tokenizer = MarianTokenizer.from_pretrained(model_name)
    # Instantiate the model
    model = MarianMTModel.from_pretrained(model_name)
    
    input_ids = tokenizer.encode(text, return_tensors='pt', add_special_tokens=True)
    with torch.no_grad():
        output = model.generate(input_ids, max_length=128, do_sample=False)
    translated_text = tokenizer.decode(output[0], skip_special_tokens=True)
    return translated_text
"""

if __name__ == "__main__":
    result = translate_text("(c'est-à-dire le score de plagiat) et la valeur de la catégorie dans l'ensemble de données choisies.  Le résultat obtenu en utilisant la similarité cosinus a montré un score de précision d'environ 92,4%. Sur la base de ce score de précision, on peut clairement voir l'impact du traitement automatique des langues sur la détection du plagiat.   Bien que ce travail ait proposé et mis en œuvre un vérificateur de plagiat alimenté par l'IA, il y a quelques limitations notables, dont la plus importante est la petite taille du corpus. Des ensembles de données plus importants seraient nécessaires pour tester l'évolutivité du modèle, ce que nous avons l'intention d'explorer dans de futurs travaux. En outre, la vérification du plagiat interlinguistique est également une voie à explorer à l'avenir, car en intégrant la PNL, notre modèle est prêt pour un support multilingue.  Si le modèle est exposé à des données dans plusieurs langues, il devrait être capable de comprendre la relation entre les mots dans plusieurs langues. ", 'fr')
    print(result)

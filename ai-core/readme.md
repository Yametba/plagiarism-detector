Configuration d’un projet
La plupart des projets Python fournissent un fichier requirements.txt qui, nous l’avons vu, donne la liste des dépendances nécessaires avec leur version. Lorsque vous récupérez un projet Python, les étapes initiales de configuration de ce projet sont quasi-systématiquement les mêmes :

Créer un environnement virtuel

Activer l’environnement virtuel

installer les dépendances déclarées par le fichier requirements.txt



$ python3.7 -m venv venv
$ source venv/bin/activate
$ pip install -r requirements.txt
$ source /media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/activate
export PYTHONPATH=/media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core:$PYTHONPATH

## Run flask server
flask --app main run

$ python core/plagiarism_checker.py --f /media/owr/3817b234-5733-4cca-be5a-21256228b837/home/owr/www/www/yametba/plagiarism-detector/ai-core/database new_docs_temp_folder/new-doc.pdf

$ python core/plagiarism_checker.py --original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great." --rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great."

$ python core/plagiarism_checker.py --original_text="The dominant sequence transduction models are based on complex recurrent or convolutional neural networks that include an encoder and a decoder. The best-performing models also connect the encoder and decoder through an attention mechanism. We propose a new simple network architecture, the Transformer, based solely on attention mechanisms, dispensing with recurrence and convolutions entirely. Experiments on two machine translation tasks show these models to be superior in quality while being more parallelizable and requiring significantly less time to train. Our model achieves 28.4 BLEU on the WMT 2014 Englishto-German translation task, improving over the existing best results, including ensembles, by over 2 BLEU. On the WMT 2014 English-to-French translation task, our model establishes a new single-model state-of-the-art BLEU score of 41.8 after training for 3.5 days on eight GPUs, a small fraction of the training costs of the best models from the literature." --rewritten_text="The best performing models for machine translation use complex recurrent neural networks that include an encoder and a decoder. We propose a new model that dispenses with these intermediate steps, using only attention mechanisms to connect the encoder and decoder. This architecture outperforms those in the literature by an order of magnitude on two machine translation tasks. In particular, our model achieves 28.4 BLEU on the WMT 2014 English-to-German translation task after training for 3 days on eight GPUs, improving over existing best results by 2 BLEU. On the WMT 2014 English-to-French translation task, our model establishes a new single-model state-of-the-art BLEU score of 41.8 after training for 3 days on eight GPUs, just a small fraction of the training costs of existing state-of-the art models from literature."
## Reste à faire avant la soutenance
Vérifier que la traduction


Configuration d’un projet
La plupart des projets Python fournissent un fichier requirements.txt qui, nous l’avons vu, donne la liste des dépendances nécessaires avec leur version. Lorsque vous récupérez un projet Python, les étapes initiales de configuration de ce projet sont quasi-systématiquement les mêmes :

Créer un environnement virtuel

Activer l’environnement virtuel

installer les dépendances déclarées par le fichier requirements.txt

$ python3.7 -m venv venv
$ source venv/bin/activate
$ conda deactivate
$ pip install -r requirements.txt
$ source /media/owr/3817b234-5733-4cca-be5a-21256228b8371/home/owr/www/www/yametba/plagiarism-detector/ai-core/venv/bin/activate
export PYTHONPATH=/media/owr/3817b234-5733-4cca-be5a-21256228b8371/home/owr/www/www/yametba/plagiarism-detector/ai-core:$PYTHONPATH
php artisan queue:work

## Run flask server
flask --app main run

## Avant une présentation
php artisan serve
php artisan queue:work
conda deactivate
cd ai-core
source venv/bin/activate

$ python core/plagiarism_checker.py --f /media/owr/3817b234-5733-4cca-be5a-21256228b8371/home/owr/www/www/yametba/plagiarism-detector/ai-core/database/new_docs_temp_folder/newdoc.pdf --analysis_item_id=18

$ python core/plagiarism_checker.py --original_text="I stand here today humbled by the task before us, grateful for the trust you have bestowed, mindful of the sacrifices borne by our ancestors. I thank President Bush for his service to our nation, as well as the generosity and cooperation he has shown throughout this transition. The new movie is awesome. The cat plays in the garden. The new movie is so great." --rewritten_text="I am humbled by the task at hand, appreciative of the trust you have placed in me, and conscious of the suffering endured by our forefathers as I stand here today. I am grateful to President Bush for his service to our country, as well as for his kindness and cooperation during this transition. The new movie is so great." --analysis_item_id=18

$ python core/plagiarism_checker.py --original_text="The dominant sequence transduction models are based on complex recurrent or convolutional neural networks that include an encoder and a decoder. The best-performing models also connect the encoder and decoder through an attention mechanism. We propose a new simple network architecture, the Transformer, based solely on attention mechanisms, dispensing with recurrence and convolutions entirely. Experiments on two machine translation tasks show these models to be superior in quality while being more parallelizable and requiring significantly less time to train. Our model achieves 28.4 BLEU on the WMT 2014 Englishto-German translation task, improving over the existing best results, including ensembles, by over 2 BLEU. On the WMT 2014 English-to-French translation task, our model establishes a new single-model state-of-the-art BLEU score of 41.8 after training for 3.5 days on eight GPUs, a small fraction of the training costs of the best models from the literature." --rewritten_text="The best performing models for machine translation use complex recurrent neural networks that include an encoder and a decoder. We propose a new model that dispenses with these intermediate steps, using only attention mechanisms to connect the encoder and decoder. This architecture outperforms those in the literature by an order of magnitude on two machine translation tasks. In particular, our model achieves 28.4 BLEU on the WMT 2014 English-to-German translation task after training for 3 days on eight GPUs, improving over existing best results by 2 BLEU. On the WMT 2014 English-to-French translation task, our model establishes a new single-model state-of-the-art BLEU score of 41.8 after training for 3 days on eight GPUs, just a small fraction of the training costs of existing state-of-the art models from literature." --analysis_item_id=18

$ python core/plagiarism_checker.py --original_text="Je me tiens ici aujourd'hui, humble face à la tâche qui nous attend, reconnaissant de la confiance que vous m'avez accordée et conscient des sacrifices consentis par nos ancêtres. Je remercie le président Bush pour les services qu'il a rendus à notre nation, ainsi que pour la générosité et la coopération dont il a fait preuve tout au long de cette transition. Le nouveau film est génial. Le chat joue dans le jardin. Le nouveau film est génial." --rewritten_text="Je me sens humble face à la tâche qui m'attend, j'apprécie la confiance que vous m'avez accordée et je suis conscient des souffrances endurées par nos ancêtres au moment où je me tiens ici aujourd'hui. Je suis reconnaissant au président Bush pour les services qu'il a rendus à notre pays, ainsi que pour sa gentillesse et sa coopération au cours de cette période de transition. Le nouveau film est génial." --analysis_item_id=18


Le modèle de détection de similarité "all-MiniLM-L6-v2" dans Hugging Face a été entraîné sur un grand nombre de langues et prend en charge la détection de similarité pour 50 langues différentes par défaut.

Voici la liste complète des langues prises en charge :

allemand (de)
anglais (en)
arabe (ar)
bengali (bn)
birman (my)
bosniaque (bs)
bulgare (bg)
catalan (ca)
chinois (zh)
croate (hr)
danois (da)
espagnol (es)
estonien (et)
finnois (fi)
français (fr)
grec (el)
hébreu (he)
hindi (hi)
hongrois (hu)
indonésien (id)
islandais (is)
italien (it)
japonais (ja)
kazakh (kk)
kirghize (ky)
coréen (ko)
letton (lv)
lituanien (lt)
macédonien (mk)
malais (ms)
maltais (mt)
néerlandais (nl)
norvégien (no)
persan (fa)
polonais (pl)
portugais (pt)
roumain (ro)
russe (ru)
serbe (sr)
slovaque (sk)
slovène (sl)
somali (so)
suédois (sv)
swahili (sw)
tagalog (tl)
tadjik (tg)
tamoul (ta)
tchèque (cs)
thaï (th)
turc (tr)
turkmène (tk)
ukrainien (uk)
ourdou (ur)
ouzbek (uz)
vietnamien (vi)




Our collective knowledge—borne out of centuries of inquiry and labor, and more interconnected and within reach today than ever before—represents the foundation of economic, cultural, and social progress made by generations of our peoples. This event reminds us of our duty, as an international community, to shape a future in which all people can fully and freely access and contribute to the great, living bank of accumulated information we share as citizens of the world. As long as we endeavor to protect and expand this access—from addressing the barriers of censorship and suppression to fighting the forces of exclusion—we can bring about a future in which every person is freer and in which all our societies are more vibrant and defined by greater possibility.



Configuration d’un projet
La plupart des projets Python fournissent un fichier requirements.txt qui, nous l’avons vu, donne la liste des dépendances nécessaires avec leur version. Lorsque vous récupérez un projet Python, les étapes initiales de configuration de ce projet sont quasi-systématiquement les mêmes :

Créer un environnement virtuel

Activer l’environnement virtuel

installer les dépendances déclarées par le fichier requirements.txt

$ python3.7 -m venv venv
$ source venv/bin/activate
$ pip install -r requirements.txt

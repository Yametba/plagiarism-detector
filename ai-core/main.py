from flask import Flask, redirect, url_for, request
import core.plagiarism_checker as plagiarism_checker

app = Flask(__name__)

@app.route("/")
def hello_world():
    return "<p>Hello, World!</p>"

@app.route("/check-plagiarism-score", methods=['POST', 'GET'])
def check_doc_plagiarism_score():
    if request.method == 'POST':
        new_doc_path = request.form['new_doc_path']
        original_text = None #request.form['original_text']
        rewritten_text = None #request.form['rewritten_text']
        result = plagiarism_checker.main(new_doc_path, original_text, rewritten_text)
        
        return "check_doc_plagiarism_score result : " + str(result)
    if request.method == 'GET':
        return "<p>Hello, World!</p>" 

@app.route("/check-plagiarism-score-between-2-text")
def check_plagiarism_score_between_2_text():
    return "def check_plagiarism_score_between_2_text()"

def get_plagiarism_score():
    return plagiarism_checker


import os
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email.mime.text import MIMEText
from email.utils import COMMASPACE
from email import encoders
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas

# Générer un fichier PDF avec ReportLab
pdf_file = "resultat.pdf"
c = canvas.Canvas(pdf_file, pagesize=letter)
c.drawString(100, 750, "Résultat de traitement")
c.save()

# Configurer les informations de l'e-mail
sender = 'plg.checker@aubled.com'
password = 'PlgChecker12_'
recipients = ['orodrigue12@gmail.com', 'webdufaso@gmail.com']
subject = 'Résultat de traitement'
body = 'Veuillez trouver ci-joint le résultat de traitement.'

# Créer l'e-mail
msg = MIMEMultipart()
msg['From'] = sender
msg['To'] = COMMASPACE.join(recipients)
msg['Subject'] = subject
msg.attach(MIMEText(body, 'plain'))

# Ajouter le fichier PDF en pièce jointe
with open(pdf_file, 'rb') as f:
    part = MIMEBase('application', "octet-stream")
    part.set_payload(f.read())
    encoders.encode_base64(part)
    part.add_header('Content-Disposition', 'attachment', filename=os.path.basename(pdf_file))
    msg.attach(part)

# Envoyer l'e-mail
smtp_server = 'smtp.hostinger.fr' #'smtp.gmail.com'
smtp_port = 587
smtp_conn = smtplib.SMTP(smtp_server, smtp_port)
smtp_conn.ehlo()
smtp_conn.starttls()
smtp_conn.login(sender, password)
smtp_conn.sendmail(sender, recipients, msg.as_string())
smtp_conn.quit()

import os
import ssl
import smtplib
from email.message import EmailMessage
from dotenv import load_dotenv
from pathlib import Path

load_dotenv()

def send_email(name: str, user_email: str, message: str):
    # Tu correo (quien recibe y desde donde se envía)
    email_sender = os.getenv("CORREO")  # Tu Gmail
    email_receiver = os.getenv("CORREO")  # El mismo (te envías a ti mismo)
    app_key = os.getenv("APP_KEY")  # Tu contraseña de aplicación
    
    subject = f"Nuevo mensaje de {name}"
    body = f"""
    Has recibido un nuevo mensaje desde el formulario de contacto:
    
    Nombre: {name}
    Correo del usuario: {user_email}
    
    Mensaje:
    {message}
    
    ---
    Para responder, envía tu correo directamente a: {user_email}
    """
    
    em = EmailMessage()
    em["From"] = f'"{name}" <{email_sender}>'  # ✅ Nombre del usuario entre comillas
    em["To"] = email_receiver  # ✅ Tu correo como destinatario
    em["Reply-To"] = user_email  # ✅ Para que cuando respondas, vaya al usuario
    em["Subject"] = subject
    em.set_content(body)
    
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as smtp:
        smtp.login(email_sender, app_key)
        smtp.send_message(em)
import os
import ssl
import smtplib
from email.message import EmailMessage
from dotenv import load_dotenv
from pathlib import Path

load_dotenv()

def send_email(name: str, phone: str, user_email: str, service_type: str, message: str):
    # Tu correo (quien recibe y desde donde se envía)
    email_sender = os.getenv("CORREO")  # Tu Gmail
    email_receiver = os.getenv("CORREO")  # El mismo (te envías a ti mismo)
    app_key = os.getenv("APP_KEY")  # Tu contraseña de aplicación

    subject = f"Home Care - Consulta: {service_type}"

    # Versión HTML adaptada al estilo visual del sitio
    html_body = f"""
    <body style="margin:0; padding:0; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color:#f5f8fa;">
        <div style="max-width:650px; margin:0 auto; background:white; border-radius:8px; box-shadow:0 4px 20px rgba(0,0,0,0.1); overflow:hidden;">
            
            <!-- Encabezado -->
            <div style="background-color:#243a73; color:white; padding:30px 20px; text-align:center;">
                <h1 style="margin:0; font-size:26px; letter-spacing:1px;"> HOME CARE GLOBAL CONSULTA</h1>
                <p style="margin-top:10px; font-size:16px;">Nueva Consulta Recibida</p>
            </div>

            <!-- Información del Cliente -->
            <div style="padding:30px 25px;">
                <h2 style="color:#243a73; font-size:20px; margin-bottom:15px;">📋 Información del Cliente</h2>

                <div style="margin-bottom:10px;"><strong>👤 Nombre:</strong> {name}</div>
                <div style="margin-bottom:10px;"><strong>📧 Email:</strong> {user_email}</div>
                <div style="margin-bottom:10px;"><strong>📱 Teléfono:</strong> {phone}</div>
                <div style="margin-bottom:10px;"><strong>🏥 Servicio:</strong> <span style="background-color:#243a73; color:white; padding:4px 12px; border-radius:20px;">{service_type}</span></div>
            </div>

            <!-- Mensaje -->
            <div style="background-color:#f0f3f8; padding:25px;">
                <h2 style="color:#243a73; font-size:20px; margin-top:0;">💬 Mensaje del Cliente</h2>
                <p style="color:#333; line-height:1.6; font-style:italic;">{message}</p>
            </div>

            <!-- Instrucciones -->
            <div style="padding:25px;">
                <h3 style="color:#1e90ff; font-size:18px;">📞 Instrucciones de Respuesta</h3>
                <ul style="padding-left:20px; color:#555; line-height:1.6;">
                    <li>Enviar un correo a: <strong>{user_email}</strong></li>
                    <li>Llamar al número: <strong>{phone}</strong></li>
                    <li>O responder desde tu cliente de correo</li>
                </ul>
            </div>

            <!-- Pie de página -->
            <div style="background-color:#243a73; color:white; text-align:center; padding:15px;">
                <p style="margin:0; font-size:13px;">© 2025 Home Care - Sistema de Contacto</p>
            </div>
        </div>
    </body>
    """

    # Fallback de texto plano
    text_body = f"""
    NUEVA CONSULTA - HOME CARE

    📋 INFORMACIÓN DEL CLIENTE:
    👤 Nombre:           {name}
    📧 Email:            {user_email}
    📱 Teléfono:         {phone}
    🏥 Servicio:         {service_type}

    💬 MENSAJE:
    {message}

    📞 INSTRUCCIONES:
    • Responder al correo: {user_email}
    • Llamar al número: {phone}
    """

    # Crear y configurar el mensaje
    em = EmailMessage()
    em["From"] = f'Home Care - {name} <{email_sender}>'
    em["To"] = email_receiver
    em["Reply-To"] = user_email
    em["Subject"] = subject
    em.set_content(text_body)
    em.add_alternative(html_body, subtype='html')

    # Enviar el correo
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL("smtp.gmail.com", 465, context=context) as smtp:
        smtp.login(email_sender, app_key)
        smtp.send_message(em)

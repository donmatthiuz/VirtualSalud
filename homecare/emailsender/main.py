from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, EmailStr
from mailer import send_email

app = FastAPI()

class ContactForm(BaseModel):
    name: str
    phone: str
    email: EmailStr
    service_type: str  # Nuevo campo para el tipo de servicio
    message: str

@app.post("/contact")
def contact_user(data: ContactForm):
    try:
        send_email(
            name=data.name,
            phone=data.phone,
            user_email=data.email,
            service_type=data.service_type,
            message=data.message
        )
        return {"message": "Mensaje enviado correctamente"}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

# Endpoint opcional para obtener tipos de servicio disponibles
@app.get("/services")
def get_services():
    return {
        "services": [
            "Cuidado de Adultos Mayores",
            "Enfermería a Domicilio",
            "Terapia Física",
            "Cuidado Post-Operatorio",
            "Acompañamiento Médico",
            "Cuidado Pediátrico",
            "Otros"
        ]
    }
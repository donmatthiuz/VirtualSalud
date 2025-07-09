from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, EmailStr
from mailer import send_email

app = FastAPI()

class ContactForm(BaseModel):
    name: str
    email: EmailStr
    message: str

@app.post("/contact")
def contact_user(data: ContactForm):
    try:
        send_email(data.name, data.email, data.message)
        return {"message": "Mensaje enviado correctamente"}
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

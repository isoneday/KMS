from tkinter import filedialog
import subprocess
import os

def path(dir):
    listArchivos = []
    listPath = []
    lstDir = os.walk(dir)

    for root, dirs, files in lstDir:
        for fichero in files:
            (nombre, extencion) = os.path.splitext(fichero)
            if (extencion == ".pdf"):
                listArchivos.append(fichero)
                listPath.append(root+"/"+fichero)


        return listPath, listArchivos

def coincidencias(path,nombre):
    dir=path
    lista=[]

    for i in range(len(dir)):
        try:
            args = "pdftotext.exe -layout -q "+ dir[i] +" -"
            texto = subprocess.check_output(args,universal_newlines=True)
            total = texto.count("seguridad")
            #print(nombre[i],total)
            #if(total == 0):
             #   print(nombre[i],"no se encontraron coincidencias",total)
             #   a = subprocess.Popen("pdf2txt {0} ".format(dir[i]), stdout=subprocess.PIPE, shell=True)
              #  (out, err)=a.communicate()
               # total = (str(out).count("seguridad"))
              #  print(nombre[i], "coincidencias", total)
            lista.append(total)
        except subprocess.CalledProcessError:
            subprocess.CalledProcessError
            lista.append(0)
    return lista

def convercioncsv(listaNombre,coincidencias):
    return

dir=filedialog.askdirectory()

direcciones, nomArchivo = path(dir)

cont=coincidencias(direcciones,nomArchivo)

for i in range(len(nomArchivo)):
    print(nomArchivo[i],cont[i])
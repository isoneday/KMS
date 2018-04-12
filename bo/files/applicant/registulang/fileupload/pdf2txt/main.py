from src import mining
from tkinter import filedialog
from PyQt4 import QtGui
dir=filedialog.askdirectory()

direcciones, nomArchivo = mining.path(dir)

cont=mining.coincidencias(direcciones,nomArchivo)

for i in range(len(nomArchivo)):
    print(nomArchivo[i],cont[i])
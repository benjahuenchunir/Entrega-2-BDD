from enum import Enum


FOLDER_DATOS = "../Datos/"
SEPARADOR = ","


class Paths(Enum):
    PATH_PROVEEDORES = f"{FOLDER_DATOS}proveedores.csv"
    PATH_MULTIMEDIA = f"{FOLDER_DATOS}multimedia.csv"
    PATH_USUARIOS = f"{FOLDER_DATOS}usuarios.csv"
    PATH_SUBSCRIPCIONES = f"{FOLDER_DATOS}subscripciones.csv"
    PATH_VISUALIZACIONES = f"{FOLDER_DATOS}visualizaciones.csv"
    PATH_PAGOS = f"{FOLDER_DATOS}pagos_v2.csv"
    PATH_GENERO_SUBGENERO = f"{FOLDER_DATOS}genero_subgenero.csv"


class PathsClean(Enum):
    PATH_PROVEEDORES = "proveedores.csv"
    PATH_PELICULAS = "peliculas.csv"
    PATH_SERIES = "series.csv"
    PATH_CAPITULOS = "capitulos.csv"
    PATH_GENEROS_SERIES = "generos_series.csv"
    PATH_GENEROS_PELICULAS = "generos_peliculas.csv"
    PATH_PELICULAS_PROVEEDORES = "proveedores_peliculas.csv"
    PATH_SERIES_PROVEEDORES = "proveedores_series.csv"
    PATH_USUARIOS = "usuarios.csv"
    PATH_SUBSCRIPCIONES = "subscripciones.csv"
    PATH_HISTORIAL_PELICULAS = "historial_peliculas.csv"
    PATH_HISTORIAL_SERIES = "historial_series.csv"
    PATH_PAGOS = "pagos.csv"
    PATH_ARRIENDOS_PELICULAS = "arriendos_peliculas.csv"
    PATH_GENEROS = "generos.csv"
    PATH_GENERO_SUBGENERO = "genero_subgenero.csv"


class Columns(Enum):
    ID = "id"
    ID_PROOVEDOR = "id_proovedor"
    NOMBRE = "nombre"
    COSTO = "costo"
    PID = "pid"
    ID_PELICULA = "id_pelicula"
    TITULO = "titulo"
    DURACION = "duracion"
    CLASIFICACION = "clasificacion"
    PUNTUACION = "puntuacion"
    AÑO = "año"
    SID = "sid"
    ID_SERIE = "id_serie"
    NOMBRE_SERIE = "serie"
    CID = "cid"
    ID_CAPITULO = "id_capitulo"
    NUMERO = "numero"
    NUMERO_TEMPORADA = "numero_temporada"
    GENERO = "genero"
    PRECIO = "precio"
    DISPONIBILIDAD = "disponibilidad"
    FECHA_INICIO = "fecha_inicio"
    FECHA_TERMINO = "fecha_termino"
    ESTADO = "estado"
    PRO_ID = "pro_id"
    UID = "uid"
    ID_USUARIO = "id_usuario"
    FECHA = "fecha"
    PAGO_ID = "pago_id"
    SUBS_ID = "subs_id"
    ID_SUBSCRIPCION = "id_subscripcion"
    MONTO = "monto"
    NOMBRE_SUBGENERO = "nombre_subgenero"
    ID_GENERO = "id_genero"
    ID_SUBGENERO = "id_subgenero"
    ID_X = "id_x"
    ID_Y = "id_y"

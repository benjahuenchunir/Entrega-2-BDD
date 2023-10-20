import pandas as pd
from parametros import Paths, PathsClean, Columns, SEPARADOR


def get_proovedores(df: pd.DataFrame):
    df = df[[Columns.ID.value, Columns.NOMBRE.value, Columns.COSTO.value]]
    df = df.drop_duplicates()
    df = df.sort_values(by=Columns.ID.value)
    df.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_PROVEEDORES.value, index=False)


def get_peliculas(df: pd.DataFrame):
    peliculas = df.dropna(subset=[Columns.PID.value])[
        [
            Columns.PID.value,
            Columns.TITULO.value,
            Columns.DURACION.value,
            Columns.PUNTUACION.value,
            Columns.CLASIFICACION.value,
            Columns.AÑO.value,
        ]
    ]
    peliculas.rename(columns={Columns.PID.value: Columns.ID.value}, inplace=True)
    peliculas[Columns.ID.value] = peliculas[Columns.ID.value].astype(int)
    peliculas.drop_duplicates(subset=[Columns.ID.value], inplace=True)
    peliculas.sort_values(by=Columns.ID.value, inplace=True)
    peliculas.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_PELICULAS.value, index=False)


def get_series(df: pd.DataFrame):
    series = df.dropna(subset=[Columns.SID.value])[
        [
            Columns.SID.value,
            Columns.NOMBRE_SERIE.value,
            Columns.CLASIFICACION.value,
            Columns.PUNTUACION.value,
            Columns.AÑO.value,
        ]
    ]
    series.rename(columns={Columns.SID.value: Columns.ID.value}, inplace=True)
    series.drop_duplicates(subset=[Columns.ID.value], inplace=True)
    series.sort_values(by=Columns.ID.value, inplace=True)
    series[Columns.ID.value] = series[Columns.ID.value].astype(int)
    series.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_SERIES.value, index=False)


def get_capitulos(df: pd.DataFrame):
    capitulos = df.dropna(subset=[Columns.SID.value])[
        [
            Columns.CID.value,
            Columns.SID.value,
            Columns.TITULO.value,
            Columns.DURACION.value,
            Columns.NUMERO.value,
        ]
    ]
    capitulos.rename(
        columns={
            Columns.NUMERO.value: Columns.NUMERO_TEMPORADA.value,
            Columns.SID.value: Columns.ID_SERIE.value,
            Columns.CID.value: Columns.ID.value,
        },
        inplace=True,
    )
    capitulos[Columns.ID.value] = capitulos[Columns.ID.value].astype(int)
    capitulos[Columns.ID_SERIE.value] = capitulos[Columns.ID_SERIE.value].astype(int)
    capitulos[Columns.NUMERO_TEMPORADA.value] = capitulos[Columns.NUMERO_TEMPORADA.value].astype(int)
    capitulos.drop_duplicates(subset=[Columns.ID.value], inplace=True)
    capitulos.sort_values(by=[Columns.ID_SERIE.value, Columns.ID.value], inplace=True)
    capitulos.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_CAPITULOS.value, index=False)


def get_generos_series(df: pd.DataFrame):
    generos_series = df.dropna(subset=[Columns.SID.value])[
        [Columns.SID.value, Columns.GENERO.value]
    ]
    generos_series.rename(
        columns={Columns.SID.value: Columns.ID_SERIE.value}, inplace=True
    )
    generos_series.drop_duplicates(inplace=True)
    generos = pd.read_csv(
        PathsClean.PATH_GENEROS.value, sep=SEPARADOR, encoding="utf8"
    )
    generos_series = pd.merge(
        generos_series, generos, on=Columns.GENERO.value, how="left"
    )
    generos_series.drop(columns=[Columns.GENERO.value], inplace=True)
    generos_series.rename(
        columns={Columns.ID.value: Columns.ID_GENERO.value}, inplace=True
    )
    # Add comedia to Rick and morty
    id_comedia = generos.loc[generos[Columns.GENERO.value] == "Comedia", Columns.ID.value].values[0]
    generos_series.loc[generos_series[Columns.ID_GENERO.value].isna(), Columns.ID_GENERO.value] = id_comedia
    generos_series.sort_values(
        by=[Columns.ID_SERIE.value, Columns.ID_GENERO.value], inplace=True
    )
    generos_series[Columns.ID_SERIE.value] = generos_series[Columns.ID_SERIE.value].astype(int)
    generos_series[Columns.ID_GENERO.value] = generos_series[Columns.ID_GENERO.value].astype(int)
    generos_series.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_GENEROS_SERIES.value, index=False)


def get_generos_peliculas(df: pd.DataFrame):
    generos_peliculas = df.dropna(subset=[Columns.PID.value])[
        [Columns.PID.value, Columns.GENERO.value]
    ]
    generos_peliculas.rename(
        columns={Columns.PID.value: Columns.ID_PELICULA.value}, inplace=True
    )
    generos = pd.read_csv(
        PathsClean.PATH_GENEROS.value, sep=SEPARADOR, encoding="utf8"
    )
    generos_peliculas.drop_duplicates(inplace=True)
    generos_peliculas = pd.merge(
        generos_peliculas, generos, on=Columns.GENERO.value, how="left"
    )
    generos_peliculas.drop(columns=[Columns.GENERO.value], inplace=True)
    generos_peliculas.rename(
        columns={Columns.ID.value: Columns.ID_GENERO.value}, inplace=True
    )
    generos_peliculas.sort_values(
        by=[Columns.ID_PELICULA.value, Columns.ID_GENERO.value], inplace=True
    )
    generos_peliculas[Columns.ID_PELICULA.value] = generos_peliculas[Columns.ID_PELICULA.value].astype(int)
    generos_peliculas.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_GENEROS_PELICULAS.value, index=False)


def get_proovedores_peliculas(df: pd.DataFrame):
    proovedores_peliculas = df.dropna(subset=[Columns.PID.value])[
        [
            Columns.ID.value,
            Columns.PID.value,
            Columns.PRECIO.value,
            Columns.DISPONIBILIDAD.value,
        ]
    ]
    proovedores_peliculas.rename(
        columns={
            Columns.ID.value: Columns.ID_PROOVEDOR.value,
            Columns.PID.value: Columns.ID_PELICULA.value,
            Columns.DISPONIBILIDAD.value: Columns.DIAS_ARRIENDO.value
        },
        inplace=True,
    )
    proovedores_peliculas[Columns.ID_PELICULA.value] = proovedores_peliculas[
        Columns.ID_PELICULA.value
    ].astype(int)
    proovedores_peliculas[Columns.PRECIO.value] = proovedores_peliculas[
        Columns.PRECIO.value
    ].astype("Int64")
    proovedores_peliculas[Columns.DIAS_ARRIENDO.value] = proovedores_peliculas[
        Columns.DIAS_ARRIENDO.value
    ].astype("Int64")
    proovedores_peliculas.sort_values(
        by=[Columns.ID_PROOVEDOR.value, Columns.ID_PELICULA.value], inplace=True
    )
    proovedores_peliculas.to_csv(encoding="utf8", path_or_buf=
        PathsClean.PATH_PELICULAS_PROVEEDORES.value, index=False
    )


def get_proovedores_series(df: pd.DataFrame):
    proovedores_series = df.dropna(subset=[Columns.SID.value])[
        [Columns.ID.value, Columns.SID.value]
    ]
    proovedores_series.rename(
        columns={
            Columns.ID.value: Columns.ID_PROOVEDOR.value,
            Columns.SID.value: Columns.ID_SERIE.value,
        },
        inplace=True,
    )
    proovedores_series.sort_values(
        by=[Columns.ID_PROOVEDOR.value, Columns.ID_SERIE.value], inplace=True
    )
    proovedores_series[Columns.ID_SERIE.value] = proovedores_series[Columns.ID_SERIE.value].astype(int)
    proovedores_series.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_SERIES_PROVEEDORES.value, index=False)


def get_historial_peliculas(df: pd.DataFrame):
    historial_peliculas = df.dropna(subset=[Columns.PID.value])[
        [Columns.UID.value, Columns.PID.value, Columns.FECHA.value]
    ]
    historial_peliculas.rename(
        columns={
            Columns.UID.value: Columns.ID_USUARIO.value,
            Columns.PID.value: Columns.ID_PELICULA.value,
        },
        inplace=True,
    )
    historial_peliculas.sort_values(
        by=[Columns.ID_USUARIO.value, Columns.ID_PELICULA.value], inplace=True
    )
    historial_peliculas.reset_index(drop=True, inplace=True)
    historial_peliculas.index += 1
    historial_peliculas.index.name = Columns.ID.value
    historial_peliculas[Columns.ID_PELICULA.value] = historial_peliculas[Columns.ID_PELICULA.value].astype(int)
    historial_peliculas.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_HISTORIAL_PELICULAS.value, index=True)


def get_historial_series(df: pd.DataFrame):
    historial_series = df.dropna(subset=[Columns.CID.value])[
        [Columns.UID.value, Columns.CID.value, Columns.FECHA.value]
    ]
    historial_series.rename(
        columns={
            Columns.UID.value: Columns.ID_USUARIO.value,
            Columns.CID.value: Columns.ID_CAPITULO.value,
        },
        inplace=True,
    )
    historial_series.sort_values(
        by=[Columns.ID_USUARIO.value, Columns.ID_CAPITULO.value], inplace=True
    )
    historial_series.reset_index(drop=True, inplace=True)
    historial_series.index += 1
    historial_series.index.name = Columns.ID.value
    historial_series[Columns.ID_CAPITULO.value] = historial_series[Columns.ID_CAPITULO.value].astype(int)
    historial_series.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_HISTORIAL_SERIES.value, index=True)


def get_pagos(df: pd.DataFrame):
    pagos = df.dropna(subset=[Columns.SUBS_ID.value])[
        [Columns.PAGO_ID.value, Columns.SUBS_ID.value, Columns.FECHA.value]
    ]
    pagos.rename(
        columns={
            Columns.PAGO_ID.value: Columns.ID.value,
            Columns.SUBS_ID.value: Columns.ID_SUBSCRIPCION.value,
        },
        inplace=True,
    )
    pagos.sort_values(
        by=[Columns.ID.value, Columns.ID_SUBSCRIPCION.value], inplace=True
    )
    pagos[Columns.ID_SUBSCRIPCION.value] = pagos[Columns.ID_SUBSCRIPCION.value].astype(int)
    pagos.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_PAGOS.value, index=False)


def get_arriendos_peliculas(df: pd.DataFrame):
    pagos = df.dropna(subset=[Columns.PID.value])[
        [
            Columns.PAGO_ID.value,
            Columns.UID.value,
            Columns.PRO_ID.value,
            Columns.PID.value,
            Columns.MONTO.value,
            Columns.FECHA.value,
        ]
    ]
    pagos.rename(
        columns={
            Columns.PAGO_ID.value: Columns.ID.value,
            Columns.UID.value: Columns.ID_USUARIO.value,
            Columns.PRO_ID.value: Columns.ID_PROOVEDOR.value,
            Columns.PID.value: Columns.ID_PELICULA.value,
        },
        inplace=True,
    )
    proveedores_peliculas = pd.read_csv(
        PathsClean.PATH_PELICULAS_PROVEEDORES.value, sep=SEPARADOR, encoding="utf8"
    )
    pagos = pd.merge(
        pagos,
        proveedores_peliculas,
        left_on=[Columns.ID_PELICULA.value, Columns.ID_PROOVEDOR.value],
        right_on=[Columns.ID_PELICULA.value, Columns.ID_PROOVEDOR.value],
        how="left",
    )
    pagos.sort_values(
        by=[
            Columns.ID.value,
            Columns.ID_USUARIO.value,
            Columns.ID_PELICULA.value,
        ],
        inplace=True,
    )
    pagos.drop(columns=[Columns.PRECIO.value, Columns.ID_PROOVEDOR.value], inplace=True)
    pagos.rename(
        columns={Columns.DISPONIBILIDAD.value: Columns.DIAS_ARRIENDO.value},
        inplace=True,
    )
    pagos[Columns.DIAS_ARRIENDO.value] = pagos[Columns.DIAS_ARRIENDO.value].astype(int)
    pagos[Columns.ID_PELICULA.value] = pagos[Columns.ID_PELICULA.value].astype(int)
    pagos.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_ARRIENDOS_PELICULAS.value, index=False)


def get_generos(df: pd.DataFrame):
    generos = df[Columns.GENERO.value].copy()
    generos = generos.drop_duplicates()
    generos = generos.sort_values()
    generos.reset_index(drop=True, inplace=True)
    generos.index += 1
    generos.index.name = Columns.ID.value
    generos.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_GENEROS.value, index=True)


def get_subgeneros(df: pd.DataFrame):
    df.dropna(subset=[Columns.NOMBRE_SUBGENERO.value], inplace=True)
    generos = pd.read_csv(
        PathsClean.PATH_GENEROS.value, sep=SEPARADOR, encoding="utf8"
    )
    generos_subgeneros = pd.merge(generos, df, on=Columns.GENERO.value, how="right")
    ids = pd.merge(
        generos_subgeneros,
        generos,
        left_on=Columns.NOMBRE_SUBGENERO.value,
        right_on=Columns.GENERO.value,
        how="left",
    )
    only_ids = ids[[Columns.ID_X.value, Columns.ID_Y.value]].copy()
    only_ids.rename(
        columns={
            Columns.ID_X.value: Columns.ID_GENERO.value,
            Columns.ID_Y.value: Columns.ID_SUBGENERO.value,
        },
        inplace=True,
    )
    only_ids.sort_values(
        by=[Columns.ID_GENERO.value, Columns.ID_SUBGENERO.value], inplace=True
    )
    only_ids.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_GENERO_SUBGENERO.value, index=False)


def clean_proovedores():
    df = pd.read_csv(Paths.PATH_PROVEEDORES.value, sep=SEPARADOR, encoding="utf8")
    get_proovedores(df)
    get_proovedores_peliculas(df)
    get_proovedores_series(df)


def clean_multimedia():
    df = pd.read_csv(Paths.PATH_MULTIMEDIA.value, sep=SEPARADOR, encoding="utf8")
    get_peliculas(df)
    get_series(df)
    get_capitulos(df)
    get_generos_series(df)
    get_generos_peliculas(df)


def clean_usuarios():
    df = pd.read_csv(Paths.PATH_USUARIOS.value, sep=SEPARADOR, encoding="utf8")
    df.sort_values(by=Columns.ID.value, inplace=True)
    df.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_USUARIOS.value, index=False)


def clean_subscripciones():
    df = pd.read_csv(Paths.PATH_SUBSCRIPCIONES.value, sep=SEPARADOR, encoding="utf8")
    subscripciones = df[
        [
            Columns.ID.value,
            Columns.PRO_ID.value,
            Columns.UID.value,
            Columns.FECHA_INICIO.value,
            Columns.FECHA_TERMINO.value,
            Columns.COSTO.value,
        ]
    ].copy()
    subscripciones.rename(
        columns={
            Columns.PRO_ID.value: Columns.ID_PROOVEDOR.value,
            Columns.UID.value: Columns.ID_USUARIO.value,
        },
        inplace=True,
    )
    subscripciones.sort_values(by=Columns.ID.value, inplace=True)
    subscripciones.to_csv(encoding="utf8", path_or_buf=PathsClean.PATH_SUBSCRIPCIONES.value, index=False)


def clean_visualizaciones():
    df = pd.read_csv(Paths.PATH_VISUALIZACIONES.value, sep=SEPARADOR, encoding="utf8")
    get_historial_peliculas(df)
    get_historial_series(df)


def clean_pagos():
    df = pd.read_csv(Paths.PATH_PAGOS.value, sep=SEPARADOR, encoding="utf8")
    get_pagos(df)
    get_arriendos_peliculas(df)


def clean_genero_subgenero():
    df = pd.read_csv(Paths.PATH_GENERO_SUBGENERO.value, sep=SEPARADOR, encoding="utf8")
    get_generos(df)
    get_subgeneros(df)


def clean_data():
    clean_genero_subgenero()
    clean_proovedores()
    clean_multimedia()
    clean_usuarios()
    clean_subscripciones()
    clean_visualizaciones()
    clean_pagos()


if __name__ == "__main__":
    clean_data()
    print("Done!")
    # TODO revisar tabla de peliculas (nulos)
    # revisar subscripciones
    # revisar tabla genero_subgenero
    # TODO en tabla arriendos se debe elimianr monto o id_proovedor seugn respuesta issue
    # id de pagos quizas no es necesaria

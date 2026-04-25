<?php


//---------------------------------------
// Constant var ventajas query
//---------------------------------------
define('COMPONENTES_QUERY', '
    query {
        getComponenteListing(defaultLanguage: "es") {
            edges {
                node {
                    id
                    modificationDate
                    titulo_es: titulo(language: "es")
                    titulo_en: titulo(language: "en")
                    titulo_fr: titulo(language: "fr")
                    descripcion_es: descripcion(language: "es")
                    descripcion_en: descripcion(language: "en")
                    descripcion_fr: descripcion(language: "fr")
                }
            }
        }
    }
');

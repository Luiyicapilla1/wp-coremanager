<?php

//---------------------------------------
// Constant var almacenamiento query
//---------------------------------------
define('ALMACENAMIENTO_QUERY', '');


//---------------------------------------
// Constant var ram query
//---------------------------------------
define('RAM_QUERY', '');


//---------------------------------------
// Constant var cpu query
//---------------------------------------
define('CPU_QUERY', '');


//---------------------------------------
// Constant var placa base query
//---------------------------------------
define('PLACA_BASE_QUERY', '');


//---------------------------------------
// Constant var gpu query
//---------------------------------------
define('GPU_QUERY', '
    query{
        getProductoListing(defaultLanguage: "es", filter: "{\"Tipo\": \"grafica\"}"){
            edges{
                node{
                    id
                    modificationDate
                    sku_es: sku(language:"es")
                    sku_en: sku(language: "en")
                    sku_fr: sku(language: "fr")
                    ean_es: ean(language: "es")
                    ean_en: ean(language: "en")
                    ean_fr: ean(language: "fr")
                    nombre_es: nombre(language: "es")
                    nombre_en: nombre(language: "en")
                    nombre_fr: nombre(language: "fr")
                    slug_es: slug(language: "es")
                    slug_en: slug(language: "en")
                    slug_fr: slug(language: "fr")
                    iva
                    stock
                    imagen{
                        fullpath
                    }
                    galeria{
                        image{
                            fullpath
                        }
                    }
                    descripcion_es: descripcion(language: "es")
                    descripcion_en: descripcion(language: "en")
                    descripcion_fr: descripcion(language: "fr")
                    titulo_seo_es: titulo_seo(language:"es")
                    titulo_seo_en: titulo_seo(language:"en")
                    titulo_seo_fr: titulo_seo(language:"fr")
                    descripcion_seo_es: descripcion_seo(language: "es")
                    descripcion_seo_en: descripcion_seo(language: "en")
                    descripcion_seo_fr: descripcion_seo(language: "fr")
                    chipset
                    vram
                    vramtype
                    tdp
                }
            }
        }
    }
');

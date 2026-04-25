<?php

/**
 * Clase GraphQLClient
 *
 * Cliente para consumir la API GraphQL de Pimcore desde el plugin.
 * Permite realizar consultas (queries) autenticadas y obtener los datos en formato array.
 * Utiliza la librería Guzzle para las peticiones HTTP.
 *
 * @package wp_coremanager
 */

namespace wp_coremanager\Services;

use GuzzleHttp\Client;

/**
 * Clase que conecta la API de pimcore con el plugin personalizado.
 */
class GraphQLClient
{
    private $client;
    private $endpoint;
    private $token;

    /**
     * Constructor de la clase.
     * Inicializa el cliente HTTP con la URL y la API key de Pimcore.
     */
    public function __construct()
    {
        // URL del endpoint GraphQL de Pimcore
        $this->endpoint = 'http://localhost/pimcore-graphql-webservices/api';
        // Token de autenticación para la API
        $this->token = '8563dffe331461c6b0e6124d7ff95fa9';

        // Instancia de Guzzle configurada con cabeceras necesarias
        $this->client = new Client([
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->token,  // Cabecera api key
            ],
        ]);
    }

    /**
     * Realiza una consulta GraphQL al endpoint de Pimcore.
     *
     * @param string $query Consulta GraphQL.
     * @param array $variables Variables para la consulta (opcional).
     * @return array Respuesta de la API (solo el nodo 'data').
     */
    public function query(string $query, array $variables = [])
    {
        try {
            // Envía la petición POST con la consulta y variables
            $response = $this->client->post($this->endpoint, [
                'json' => [
                    'query' => $query,
                    'variables' => $variables,
                ],
            ]);
            // Decodifica la respuesta JSON
            $data = json_decode($response->getBody()->getContents(), true);
            // Devuelve solo el nodo 'data' o un array vacío si no existe
            return $data['data'] ?? [];
        } catch (\Exception $e) {
            // Log de errores para diagnóstico
            error_log('GraphQLClient ERROR: ' . $e->getMessage());
            return [];
        }
    }
}

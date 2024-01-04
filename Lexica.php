<?php

class Lexica
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function jsonClean()
    {
        $postData = json_encode([
            "text" => $this->query,
            "searchMode" => "images",
            "source" => "search",
            "model" => "lexica-aperture-v2"
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://lexica.art/api/infinite-prompts");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);

        $output = [];
        foreach ($responseData['prompts'] as $prompt) {
            $images = [];
            foreach ($prompt['images'] as $image) {
                $url = "https://image.lexica.art/full_jpg/{$image['id']}";
                $image['url'] = $url;
                $images[] = $image;
            }
            $prompt['images'] = $images;
            $output[] = $prompt;
        }
        $creat = "MehrshadRahmani";
        header('Content-type: application/json; charset=utf-8');
        echo json_encode([ 'Developer' => $creat , 'nextCursor' => $responseData['nextCursor'], 'prompts' => $output], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }


    public function json()
    {
        $postData = json_encode([
            "text" => $this->query,
            "searchMode" => "images",
            "source" => "search",
            "model" => "lexica-aperture-v2"
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://lexica.art/api/infinite-prompts");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);

        $output = [];
        foreach ($responseData['prompts'] as $prompt) {
            $images = [];
            foreach ($prompt['images'] as $image) {
                $url = "https://image.lexica.art/full_jpg/{$image['id']}";
                $image['url'] = $url;
                $images[] = $image;
            }
            $prompt['images'] = $images;
            $output[] = $prompt;
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode(['nextCursor' => $responseData['nextCursor'], 'prompts' => $output]);
    }
}

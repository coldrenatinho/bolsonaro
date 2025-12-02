<?php
namespace App\Payment;

class PixPayment
{
    private $pixKey;
    private $pixName;
    private $pixCity;
    private $identificador;

    public function __construct($pixKey, $pixName, $pixCity, $identificador = 'PETICAO')
    {
        $this->pixKey = $pixKey;
        $this->pixName = strtoupper($pixName);
        $this->pixCity = strtoupper($pixCity);
        $this->identificador = $identificador;
    }

    public function generatePayload($valor = null)
    {
        $payload = "00020126";
        $payload .= str_pad(strlen($this->pixKey) + 14, 2, '0', STR_PAD_LEFT);
        $payload .= "0014br.gov.bcb.pix01";
        $payload .= str_pad(strlen($this->pixKey), 2, '0', STR_PAD_LEFT);
        $payload .= $this->pixKey;
        $payload .= "520400005303986";
        
        if ($valor && $valor > 0) {
            $valorStr = number_format($valor, 2, '.', '');
            $payload .= "54" . str_pad(strlen($valorStr), 2, '0', STR_PAD_LEFT) . $valorStr;
        }
        
        $payload .= "5802BR";
        $payload .= "59" . str_pad(strlen($this->pixName), 2, '0', STR_PAD_LEFT) . $this->pixName;
        $payload .= "60" . str_pad(strlen($this->pixCity), 2, '0', STR_PAD_LEFT) . $this->pixCity;
        $payload .= "62" . str_pad(strlen($this->identificador) + 4, 2, '0', STR_PAD_LEFT);
        $payload .= "05" . str_pad(strlen($this->identificador), 2, '0', STR_PAD_LEFT) . $this->identificador;
        $payload .= "6304";
        
        return $payload . $this->calculateCRC16($payload);
    }

    public function generateQRCode($valor = null, $size = 300)
    {
        $payload = $this->generatePayload($valor);
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($payload);
    }

    private function calculateCRC16($str)
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($str); $i++) {
            $crc ^= ord($str[$i]) << 8;
            for ($j = 0; $j < 8; $j++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc <<= 1;
                }
            }
        }
        return strtoupper(dechex($crc & 0xFFFF));
    }

    public function getPixKey()
    {
        return $this->pixKey;
    }
}

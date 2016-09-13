<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 03/09/16
 * Time: 08:57
 */

namespace App\Controllers;


class DataPostagem
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * DataPostagem constructor.
     * @param \DateTime $date
     */
    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }
    
    /**
     * @return string
     */
    public function getTempoPostagem()
    {
        $dataAtual = new \DateTime('now');
        $dataPostagem = $this->date;
        $mensagem = 'postado agora';
        
        if ($dataAtual->format('Y') > $dataPostagem->format('Y')) {
            $mensagem = $y = $dataAtual->format('Y') - $dataPostagem->format('Y') . ' anos atrás';
        } elseif ($dataAtual->format('m') > $dataPostagem->format('m')) {
            $mensagem = $dataAtual->format('m') - $dataPostagem->format('m') . ' meses atrás';
        } elseif ($dataAtual->format('d') > $dataPostagem->format('d')) {
            $mensagem = $dataAtual->format('d') - $dataPostagem->format('d') . ' dias atrás';
        } elseif ($dataAtual->format('H') > $dataPostagem->format('H')) {
            $mensagem = $dataAtual->format('H') - $dataPostagem->format('H') . ' horas atrás';
        } elseif ($dataAtual->format('i') > $dataPostagem->format('m')) {
            $mensagem = $dataAtual->format('i') - $dataPostagem->format('m') . ' minutos atrás';
        } elseif ($dataAtual->format('s') > $dataPostagem->format('s')) {
            $mensagem = $dataAtual->format('s') - $dataPostagem->format('s') . ' segundos atrás';
        }
        return $mensagem;
    }
}
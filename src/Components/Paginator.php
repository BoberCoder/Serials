<?php

namespace Serials\Components;


class Paginator
{
    private $all;
    private $limit;
    private $linkLimit;
    private $page;

    /**
     * @param int $all        - Полное кол-во элементов (Материалов в категории)
     * @param int $limit      - Кол-во элементов на странице
     * @param int $page      - Текущее смещение элементов
     * @param int $linkLimit  - Количество ссылок в состоянии
     */
    public function __construct($all,$limit,$linkLimit,$page)
    {
        $this->all = $all;
        $this->limit = $limit;
        $this->linkLimit = $linkLimit;
        $this->page = $page;
    }

    /**

     * @return string
     */
    public function getLinks()
    {
        $pages     = 0;       // кол-во страниц в пагинации
        $needChunk = 0;       // индекс нужного в данный момент чанка
        $pagesArr  = array(); // пременная для промежуточного хранения массива навигации
        $link      = NULL;    // формируемая ссылка



        $pages = ceil( $this->all / $this->limit );

        for( $i = 0; $i < $pages; $i++) {
            $pagesArr[$i+1] = $i * $this->limit;
        }

        $allPages = array_chunk($pagesArr, $this->linkLimit, true);


        $needChunk = $this->searchPage( $allPages, $this->page);

        // Формируем ссылки "В начало", "передыдущая" ------------------------------------------------

//        if ( $start > 1 ) {
//            $htmlOut .= '<li><a href="'.$link.'&'.$varName.'=0">'.$this->startChar.'</a></li>'.
//                '<li><a href="'.$link.'&'.$varName.'='.($start - $limit).'">'.$this->prevChar.'</a></li>';
//        } else {
//            $htmlOut .= '<li><span>'.$this->startChar.'</span></li>'.
//                '<li><span>'.$this->prevChar.'</span></li>';
//        }
//        // Собсно выводим ссылки из нужного чанка
//        foreach( $allPages[$needChunk] AS $pageNum => $ofset )  {
//            // Делаем текущую страницу не активной:
//            if( $ofset == $start  ) {
//                $htmlOut .= '<li><span>'. $pageNum .'</span></li>';
//                continue;
//            }
//            $htmlOut .= '<li><a href="'.$link.'&'.$varName.'='. $ofset .'">'. $pageNum . '</a></li>';
//        }

        // Формируем ссылки "следующая", "в конец" ------------------------------------------------

//        if ( ($all - $limit) >  $start) {
//            $htmlOut .= '<li><a href="' . $link . '&' . $varName . '=' . ( $start + $limit) . '">' . $this->nextChar . '</a></li>'.
//                '<li><a href="' . $link . '&' . $varName . '=' . array_pop( array_pop($allPages) ) . '">' . $this->endChar . '</a></li>';
//        } else {
//            $htmlOut .= '<li><span>' . $this->nextChar . '</span></li>'.
//                '<li><span>' . $this->endChar . '</span></li>';
//        }
        return $allPages[$needChunk];
    }

    /**
     * Ищет в каком чанке находится сраница со смещением $needPage
     * @param array $pagesList массив чанков (массивов страниц разбитый по лимиту ссылок на странице)
     * @param int $needPage - смещение
     * @return number Ключ чанка в котором есть нужная страница
     */
    protected function searchPage($pagesList,$needPage)
    {
        foreach( $pagesList AS $chunk => $pages  ){
            if( array_key_exists($needPage, $pages) ){
                return $chunk;
            }
        }
        return 0;
    }
}
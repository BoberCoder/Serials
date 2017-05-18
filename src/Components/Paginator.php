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
     * @return array
     */
    public function getLinks()
    {
        $pages     = 0;       // кол-во страниц в пагинации
        $needChunk = 0;       // индекс нужного в данный момент чанка
        $pagesArr  = array(); // пременная для промежуточного хранения массива навигации



        $pages = ceil( $this->all / $this->limit );

        for( $i = 0; $i < $pages; $i++) {
            $pagesArr[$i+1] = $i * $this->limit;
        }

        $allPages = array_chunk($pagesArr, $this->linkLimit, true);


        $needChunk = $this->searchPage( $allPages, $this->page);

        return array("chunk" =>$allPages[$needChunk],"pages"=>$pages);
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
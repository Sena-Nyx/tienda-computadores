<?php
class Productos {

    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    private $categoria;
    
    public function __construct($nombre, $descripcion, $precio, $imagen, $categoria)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->imagen = $imagen;
        $this->categoria = $categoria;
        
    }
    public function obtenernombre(){
        return $this->nombre;
    }
    public function obtenerdescripcion(){
        return $this->descripcion;
    }
    public function obtenerprecio(){
        return $this->precio;
    }
    public function obtenerimagen(){
        return $this->imagen;
    }
    public function obtenercategoria(){
        return $this->categoria;
    }
}
?>
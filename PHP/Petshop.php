<?php
class Petshop{
    // Attribute
    private $ID;
    private $nama;
    private $kategori;
    private $harga;
    private $gambar;

    // Constructor
    public function __construct($ID="", $nama="", $kategori="", $harga=0, $gambar=""){
        $this->ID = $ID;
        $this->nama = $nama;
        $this->kategori = $kategori;
        $this->harga = $harga;
        $this->gambar = $gambar;
    }

    // Setter
    public function set_ID($ID){ $this->ID = $ID;}
    public function set_nama($nama){ $this->nama = $nama;}
    public function set_kategori($kategori){$this->kategori = $kategori;}
    public function set_harga($harga){$this->harga = $harga;}
    public function set_gambar($gambar){$this->gambar = $gambar;}
    
    // Getter
    public function get_ID(){ return $this->ID;}   
    public function get_nama(){ return $this->nama;}
    public function get_kategori(){return $this->kategori;}
    public function get_harga(){return $this->harga;}
    public function get_gambar(){return $this->gambar;}

    public function tampil(){
        return "ID: ".$this->ID."<br>Nama: ".$this->nama."<br>Kategori: ".$this->kategori."<br>Harga: ".$this->harga."<br>Gambar: ".$this->gambar;
    }
}
?>
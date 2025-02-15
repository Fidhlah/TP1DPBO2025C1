/*
Saya Muhammad Hafidh Fadhilah dengan NIM 2305672 mengerjakan Latihan Modul 1 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.
*/
#include <iostream>
#include <string>

using namespace std;

class Petshop{
    private:
        // Atribut untuk menyimpan informasi produk
        string ID;        // ID produk
        string nama;      // Nama produk
        string kategori;  // Kategori produk
        int harga;        // Harga produk

    public:
        // Konstruktor default (inisialisasi tanpa nilai awal)
        Petshop(){
            this->ID = "";
            this->nama = "";
            this->kategori = "";
            this->harga = 0;
        }

        // Konstruktor parameter ( inisialisasi dengan nilai tertentu)
        Petshop(string ID, string nama, string kategori, int harga){
            this->ID = ID;
            this->nama = nama;
            this->kategori = kategori;
            this->harga = harga;
        }

        // Setter atribut
        void set_ID(string ID) {this->ID = ID;}
        void set_nama(string nama){this->nama = nama;}
        void set_kategori(string kategori){ this->kategori = kategori;}
        void set_harga(int harga){this->harga= harga;}
        
        // Getter atribut
        string get_ID(){return this->ID;}
        string get_nama(){return this->nama;}
        string get_kategori(){return this->kategori;}
        int get_harga(){return this->harga;}
        
        // Metode untuk menampilkan data dalam bentuk tabel
        void tampil(){
            // Garis pemisah tabel
            for(size_t i = 0; i < 80; i++) cout << "-";
            cout << '\n';

            // Menampilkan ID
            cout << this->ID;
            for (size_t i = this->ID.length();i < 5;i++) cout << " ";
            cout << " | ";

            // Menampilkan Nama
            cout << this->nama;
            for(size_t i = this->nama.length();i < 35;i++) cout << " ";
            cout << " | ";

            // Menampilkan Kategori
            cout << this->kategori;
            for(size_t i = this->kategori.length();i < 25;i++) cout << " ";
            cout << " | ";

            // Menampilkan Harga
            cout << this->harga << '\n';
        }

        // Destructor 
        ~Petshop() {}
};

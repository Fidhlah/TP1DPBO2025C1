public class Petshop{
    private String ID;
    private String nama;
    private String kategori;
    private int harga;

    // Constructor
    public Petshop(){
        this.ID="";
        this.nama="";
        this.kategori="";
        this.harga=0;
    }

    // Constructor dengan parameter
    public Petshop(String ID, String nama, String kategori, int harga){
        this.ID = ID;
        this.nama = nama;
        this.kategori = kategori;
        this.harga = harga;
    }

    // Setter
    public void set_ID(String ID) {this.ID = ID;}
    public void set_nama(String nama){this.nama = nama;}
    public void set_kategori(String kategori){this.kategori = kategori;}
    public void set_harga(int harga){this.harga = harga;}

    // Getter
    public String get_ID(){ return this.ID;}
    public String get_nama(){return this.nama;}
    public String get_kategori(){return this.kategori;}
    public int get_harga(){return this.harga;}

    // Menampilkan data
    public void tampil(){
        // Garis pemisah tabel
        System.out.println("-".repeat(80));

        // Menampilkan ID
        System.out.print(this.ID);
        System.out.print(" ".repeat(5 - ID.length()) + " | ");

        // Menampilkan Nama
        System.out.print(this.nama);
        System.out.print(" ".repeat(35 - nama.length()) + " | ");

        // Menampilkan Kategori
        System.out.print(this.kategori);
        System.out.print(" ".repeat(25 - kategori.length()) + " | ");

        // Menampilkan Harga
        System.out.println(this.harga);
    }
}
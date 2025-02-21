import java.util.ArrayList;
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        ArrayList<Petshop> petshop = new ArrayList<>();
        
        // Data Dummy
        petshop.add(new Petshop("001", "Royal Canin Kitten", "Makanan Kucing", 250000));
        petshop.add(new Petshop("002", "Pedigree Beef & Vegetable", "Makanan Anjing", 50000));
        petshop.add(new Petshop("003", "Detick Obat Kutu Anjing", "Obat Anjing", 55000));
        petshop.add(new Petshop("004", "Petmate Litter Scoop", "Aksesoris Hewan", 15000));
        petshop.add(new Petshop("005", "Hikari Oranda Gold", "Makanan Ikan", 59000));
        
        // Variabel untuk menyimpan input
        String ID, nama, kategori;
        int harga, choice;
        
        try(Scanner input = new Scanner(System.in)){
            // Looping menu
            do {
                boolean found = false;  // Untuk mengecek apakah data ditemukan

                // Menampilkan menu utama
                System.out.println("\n---------------------");
                System.out.println("|      PETSHOP      |");
                System.out.println("---------------------");
                System.out.println("1. Menampilkan data");
                System.out.println("2. Menambahkan data");
                System.out.println("3. Mengubah data");
                System.out.println("4. Menghapus data");
                System.out.println("5. Mencari data");
                System.out.println("6. Keluar");
                System.out.print("Pilihan: ");
    
                // Input pilihan
                choice = input.nextInt();
                input.nextLine();
    
                if(choice == 1){ // Menampilkan data
                    for(Petshop petshop2 : petshop){
                        petshop2.tampil();
                    }
                }else if(choice == 2){ // Menambahkan data
                    System.out.print("Masukkan ID: ");
                    ID = input.nextLine();
    
                    System.out.print("Masukkan Nama: ");
                    nama = input.nextLine(); 
    
                    System.out.print("Masukkan Kategori: ");
                    kategori = input.nextLine(); 
    
                    try{
                        System.out.print("Masukkan Harga: ");
                        harga = Integer.parseInt(input.nextLine());
                    }catch (NumberFormatException e){
                        System.out.println("Input harga harus berupa angka!");
                        return;  // Keluar dari fungsi kalau input salah
                    }
    
                    petshop.add(new Petshop(ID, nama, kategori, harga));
                    System.out.println("Data berhasil ditambahkan!");
    
                }else if(choice == 3){ // Mengubah data
                    System.out.print("Masukkan ID yang ingin diubah: ");
                    ID = input.nextLine(); 
    
                    int i = 0;
                    while(i < petshop.size() && !found){
                        Petshop petshop2 = petshop.get(i);
                        if(petshop2.get_ID().equals(ID)){
                            found = true;
                    
                            // Scan input ID baru
                            System.out.print("Masukkan ID baru (Enter untuk tetap): ");
                            String newID = input.nextLine();
                            if(!newID.isEmpty()){ // Jika input tidak kosong, ubah ID
                                petshop2.set_ID(newID);
                            }
                    
                            // Scan input Nama baru
                            System.out.print("Masukkan Nama baru (Enter untuk tetap): ");
                            String newNama = input.nextLine();
                            if(!newNama.isEmpty()){ // Jika input tidak kosong, ubah Nama
                                petshop2.set_nama(newNama);
                            }
                    
                            // Scan input Kategori baru
                            System.out.print("Masukkan Kategori baru (Enter untuk tetap): ");
                            String newKategori = input.nextLine();
                            if(!newKategori.isEmpty()){ // Jika input tidak kosong, ubah Kategori
                                petshop2.set_kategori(newKategori);
                            }
                    
                            // Scan input Harga baru
                            System.out.print("Masukkan Harga baru (Enter untuk tetap): ");
                            String newHarga = input.nextLine();
                            if(!newHarga.isEmpty()){ // Jika input tidak kosong, ubah Harga
                                try{
                                    int hargaBaru = Integer.parseInt(newHarga);
                                    petshop2.set_harga(hargaBaru);
                                }catch (NumberFormatException e){
                                    System.out.println("Input harga harus berupa angka!");
                                }
                            }
                    
                            System.out.println("Data berhasil diubah!");
                        }
                        i++;
                    }
    
                    if(!found){ // Jika data tidak ditemukan
                        System.out.println("Data tidak ditemukan!");
                    }
                }else if(choice == 4){ // Menghapus data
                    System.out.print("Masukkan ID yang ingin dihapus: ");
                    ID = input.nextLine();
    
                    int i = 0;
                    while(i < petshop.size() && !found){
                        if(petshop.get(i).get_ID().equals(ID)){
                            found = true;
                            petshop.remove(i);
                            System.out.println("Data berhasil dihapus!");
                        }else{
                            i++;
                        }
                    }
    
                    if(!found){ // Jika data tidak ditemukan
                        System.out.println("Data tidak ditemukan!");
                    }
    
                }else if(choice == 5){ // Mencari data
                    System.out.print("Masukkan nama yang ingin dicari: ");
                    nama = input.nextLine();
    
                    int i = 0;
                    while(i < petshop.size() && !found){
                        if(petshop.get(i).get_nama().equals(nama)){
                            found = true;
                            petshop.get(i).tampil();
                        }
                        i++;
                    }
                    if(!found){ // Jika data tidak ditemukan
                        System.out.println("Data tidak ditemukan!");
                    }
    
                } 
            }while(choice != 6);
            
            System.out.println("Terima kasih telah menggunakan program ini");
        }
        
        
    }
}

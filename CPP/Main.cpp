/*
Saya Muhammad Hafidh Fadhilah dengan NIM 2305672 mengerjakan Latihan Modul 1 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.
*/

#include <iostream>
#include <string>
#include <list>
#include "Petshop.cpp"

using namespace std;

int main() {
    list<Petshop> petshop;  // List untuk menyimpan data produk di petshop

    // Data Dummy (bisa uncomment jika tidak ingin input manual)
    // petshop.push_back(Petshop("001", "Royal Canin Kitten", "Makanan Kucing", 250000));
    // petshop.push_back(Petshop("002", "Pedigree Beef & Vegetable", "Makanan Anjing", 50000));
    // petshop.push_back(Petshop("003", "Detick Obat Kutu Anjing", "Obat Anjing", 55000));
    // petshop.push_back(Petshop("004", "Petmate Litter Scoop", "Aksesoris Hewan", 15000));
    // petshop.push_back(Petshop("005", "Hikari Oranda Gold", "Makanan Ikan", 59000));
    // petshop.push_back(Petshop("006", "TetraBits Complete", "Makanan Ikan", 103800));
    // petshop.push_back(Petshop("007", "Tower Kucing", "Mainan Hewan", 379000));
    // petshop.push_back(Petshop("008", "Pawise Cat Scratcher", "Mainan Hewan", 18900));

    // Sebagai tempat menyimpan input pengguna
    string ID, nama, kategori;
    int harga, choice;

    do{
        // Menampilkan menu utama
        cout << "\n---------------------\n"
             << "|      PETSHOP      |\n"
             << "---------------------\n"
             << "1. Menampilkan data\n"
             << "2. Menambahkan data\n"
             << "3. Mengubah data\n"
             << "4. Menghapus data\n"
             << "5. Mencari data\n"
             << "6. Keluar\n"
             << "Pilihan: ";
        
        cin >> choice;       // Input pilihan menu
        cin.ignore();        // Membersihkan buffer

        bool found = false;  // Flag untuk menandai jika data ditemukan

        if(choice == 1){  // Menampilkan semua data produk
            for(Petshop p : petshop){
                p.tampil();
            }
        }else if(choice == 2){  // Menambahkan produk baru
            cout << "Masukkan ID: ";
            getline(cin, ID);
            cout << "Masukkan Nama: ";
            getline(cin, nama);
            cout << "Masukkan Kategori: ";
            getline(cin, kategori);
            cout << "Masukkan Harga: ";
            cin >> harga;
            cin.ignore();  

            // Memasukkan data produk ke list
            petshop.push_back(Petshop(ID, nama, kategori, harga));
            cout << "Produk berhasil ditambahkan!\n";
        }else if(choice == 3){  // Mengubah data produk
            cout << "Masukkan ID produk yang ingin diubah: ";
            getline(cin, ID);

            auto it = petshop.begin();  // Insialisasi iterator ke elemen pertama
            while(it != petshop.end() && !found){   // Selama iterator belum mencapai elemen terakhir dan data belum ditemukan
                if(it->get_ID() == ID){ // Jika ID produk ditemukan
                    found = true;
            
                    cout << "Masukkan ID Baru (Enter untuk tetap): ";
                    string new_ID;
                    getline(cin, new_ID);
                    if (!new_ID.empty()) it->set_ID(new_ID); // Jika input tidak kosong, set ID baru
            
                    cout << "Masukkan Nama Baru (Enter untuk tetap): ";
                    string new_nama;
                    getline(cin, new_nama);
                    if (!new_nama.empty()) it->set_nama(new_nama); // Jika input tidak kosong, set Nama baru
            
                    cout << "Masukkan Kategori Baru (Enter untuk tetap): ";
                    string new_kategori;
                    getline(cin, new_kategori);
                    if (!new_kategori.empty()) it->set_kategori(new_kategori); // Jika input tidak kosong, set Kategori baru
            
                    cout << "Masukkan Harga Baru (Enter untuk tetap): ";
                    string harga_input;
                    getline(cin, harga_input);
                    if (!harga_input.empty()) it->set_harga(stoi(harga_input)); // Jika input tidak kosong, set Harga baru. Tetapi, gunakan stoi untuk mengubah string menjadi integer
            
                    cout << "Produk berhasil diperbarui!\n";
                }
                ++it;  // Geser iterator ke elemen berikutnya
            }

            if(!found) cout << "Produk dengan ID \"" << ID << "\" tidak ditemukan.\n";
        }else if(choice == 4){  // Menghapus produk berdasarkan nama
            cout << "Masukkan nama produk yang ingin dihapus: ";
            getline(cin, nama);

            auto it = petshop.begin(); // Insialisasi iterator ke elemen pertama
            while(it != petshop.end() && !found){ // Selama iterator belum mencapai elemen terakhir dan data belum ditemukan
                if(it->get_nama() == nama){
                    cout << "\"" << it->get_nama() << "\" telah dihapus.\n";
                    it = petshop.erase(it);  // Menghapus elemen dari list
                    found = true;
                }else ++it;  // Geser iterator ke elemen berikutnya
            }

            if(!found) cout << "Produk \"" << nama << "\" tidak ditemukan.\n";
            
        }else if(choice == 5){  // Mencari produk berdasarkan nama
            cout << "Masukkan nama produk yang ingin dicari: ";
            getline(cin, nama);

            // Mencari produk berdasarkan nama
            for (Petshop p : petshop) {
                if (p.get_nama() == nama) {
                    p.tampil();
                    found = true;
                }
            }

            if(!found) cout << "Produk \"" << nama << "\" tidak ditemukan.\n";
        }
    } while (choice != 6);  // Loop berhenti jika pengguna memilih keluar

    return 0;
}

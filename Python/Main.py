from Petshop import Petshop

# Inisialisasi list petshop
petshop = []


# Data Dummy
petshop.append(Petshop("PY001", "Royal Canin Kitten", "Makanan Kucing", 250000))
petshop.append(Petshop("PY002", "Pedigree Beef & Vegetable", "Makanan Anjing", 50000))
petshop.append(Petshop("PY003", "Detick Obat Kutu Anjing", "Obat Anjing", 55000))
petshop.append(Petshop("PY004", "Petmate Litter Scoop", "Aksesoris Hewan", 15000))
petshop.append(Petshop("PY005", "Hikari Oranda Gold", "Makanan Ikan", 59000))

# inisialisasi variabel choice
choice=0

# Menu
while choice != "6":

    # Menampilkan menu
    print("\n---------------------")
    print("|      PETSHOP      |")
    print("---------------------")
    print("1. Menampilkan data")
    print("2. Menambahkan data")
    print("3. Mengubah data")
    print("4. Menghapus data")
    print("5. Mencari data")
    print("6. Keluar")
    choice = input("Pilihan: ")

    if choice == "1":   # Menampilkan data
        for i in petshop:
            i.tampil()
    elif choice == "2": # Menambahkan data
        ID = input("Masukkan ID: ")
        nama = input("Masukkan Nama: ")
        kategori = input("Masukkan Kategori: ")
        harga = int(input("Masukkan Harga: "))
        petshop.append(Petshop(ID, nama, kategori, harga))
        
        print("Data berhasil ditambahkan!")
    elif choice == "3": # Mengubah data
        ID = input("Masukkan ID yang ingin diubah: ")
        for i in petshop:
            if i.get_ID() == ID:
                ID_baru = input("Masukkan ID (Enter untuk tetap): ")
                if ID_baru:
                    i.set_ID(ID_baru)

                nama_baru = input("Masukkan Nama (Enter untuk tetap): ")
                if nama_baru:
                    i.set_nama(nama_baru)

                kategori_baru = input("Masukkan Kategori (Enter untuk tetap): ")
                if kategori_baru:
                    i.set_kategori(kategori_baru)

                harga_baru = input("Masukkan Harga (Enter untuk tetap): ")
                if harga_baru:
                    i.set_harga(int(harga_baru))
                
                print("Data berhasil diubah!")

    elif choice == "4": # Menghapus data
        ID = input("Masukkan ID yang ingin dihapus: ")
        found = False
        i = 0

        # Mencari data yang ingin dihapus berdasarkan ID
        while i < len(petshop) and not found:
            if petshop[i].get_ID() == ID:
                del petshop[i]
                print("Data berhasil dihapus!")
                found = True
            else:
                i += 1

        if not found:
            print("Data tidak ditemukan!")

    elif choice == "5": # Mencari data
        nama = input("Masukkan nama yang ingin dicari: ")
        found = False
        i = 0

        # Mencari data berdasarkan nama
        while i < len(petshop) and not found:
            if petshop[i].get_nama() == nama:
                petshop[i].tampil()
                found = True
            else:
                i += 1

        if not found:
            print("Data tidak ditemukan!")


print("Terima kasih telah menggunakan program ini")
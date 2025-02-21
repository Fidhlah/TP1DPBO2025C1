class Petshop:
    # Atribut
    __ID=""
    __nama=""
    __kategori=""
    __harga=0

    # Constructor
    def __init__(self,ID,nama,kategori,harga):
        self.__ID=ID
        self.__nama=nama
        self.__kategori=kategori
        self.__harga=harga
    
    # Setter
    def set_ID(self,ID):
        self.__ID=ID
    
    def set_nama(self,nama):
        self.__nama=nama
    
    def set_kategori(self,kategori):
        self.__kategori=kategori
    
    def set_harga(self,harga):
        self.__harga=harga
    
    ## Getter
    def get_ID(self):
        return self.__ID
    
    def get_nama(self):
        return self.__nama
    
    def get_kategori(self):
        return self.__kategori
    
    def get_harga(self):
        return self.__harga
    
    # Method
    def tampil(self):
        print("-" * 80)

        # Menampilkan ID
        print(f"{self.__ID}{' ' * (5 - len(self.__ID))} | ", end="")

        # Menampilkan Nama
        print(f"{self.__nama}{' ' * (35 - len(self.__nama))} | ", end="")

        # Menampilkan Kategori
        print(f"{self.__kategori}{' ' * (25 - len(self.__kategori))} | ", end="")

        # Menampilkan Harga
        print(self.__harga)

    
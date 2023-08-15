export const parser = (key) => {
    switch(key) {
        case 'Ekr. reg.':
            return 'Ekran po regeneracji';
        case 'Ekr. org.':
            return 'Ekran oryginalny';
        case 'Ekr. zam.':
            return 'Ekran zamiennik';
        case 'Ekr. demo.':
            return 'Ekran z demontażu';
        case 'Plecki org.':
            return 'Plecki oryginalne';
        case 'Plecki zam.':
            return 'Plecki zamiennik';
        case 'Plecki demo.':
            return 'Plecki z demontażu';
        case 'Bateria org.':
            return 'Bateria oryginalna';
        case 'Bateria zam.':
            return 'Bateria zamiennik'
        case 'Port ładow.':
            return 'Port ładowania'
        case 'Głośnik dol.':
            return 'Głośnik dolny';
        case 'Głośnik gór.':
            return 'Głośnik górny'
        default: 
            return key;
    }
}

export const additionalMessage = (key) => {
    switch(key) {
        case 'Ekr. reg.':
            return 'Aby regeneracja była możliwa zarówno dotyk jak i matryca muszą być sprawne. Regeneracja polega na wymianie zewnętrznej szybki wyświetlacza, dzięki czemu ekran dalej pozostaje oryginalny.';
        default: 
        return '';
    }
}

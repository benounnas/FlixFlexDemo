export interface Movie {
    id: number;
    title: string;
    poster_path: string;
    backdrop_path: string;
    overview: string;
    release_date: string;
    runtime: number;
    vote_average: number;
    genres: Genre[];
    production_companies: ProductionCompany[];
    spoken_languages: Language[];
    videos?: {
        results: Video[];
    };
}

interface Genre {
    id: number;
    name: string;
}

interface ProductionCompany {
    id: number;
    name: string;
    logo_path: string | null;
    origin_country: string;
}

interface Language {
    english_name: string;
    iso_639_1: string;
    name: string;
}

interface Video {
    id: string;
    key: string;
    name: string;
    site: string;
    type: string;
}
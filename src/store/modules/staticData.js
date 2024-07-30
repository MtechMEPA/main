const state = () => ({
    regencies: [
        {
            id: "deiyai001",
            name: "Kabupaten Deiyai",
            districts: [
                { id: "deiyai_d001", name: "Tigi" },
                { id: "deiyai_d002", name: "Tigi Barat" },
                { id: "deiyai_d003", name: "Tigi Timur" },
                { id: "deiyai_d004", name: "Bowobado" },
                { id: "deiyai_d005", name: "Kapiraya" }
            ]
        },
        {
            id: "dogiyai002",
            name: "Kabupaten Dogiyai",
            districts: [
                { id: "dogiyai_d001", name: "Kamu" },
                { id: "dogiyai_d002", name: "Kamu Utara" },
                { id: "dogiyai_d003", name: "Kamu Selatan" },
                { id: "dogiyai_d004", name: "Kamu Timur" },
                { id: "dogiyai_d005", name: "Mapia" },
                { id: "dogiyai_d006", name: "Mapia Barat" },
                { id: "dogiyai_d007", name: "Piyaiye" },
                { id: "dogiyai_d008", name: "Sukikai Selatan" },
                { id: "dogiyai_d009", name: "Mapia Tengah" }
            ]
        },
        {
            id: "intanjaya003",
            name: "Kabupaten Intan Jaya",
            districts: [
                { id: "intan_d001", name: "Agisiga" },
                { id: "intan_d002", name: "Biandoga" },
                { id: "intan_d003", name: "Hitadipa" },
                { id: "intan_d004", name: "Homeyo" },
                { id: "intan_d005", name: "Mbiandoga" },
                { id: "intan_d006", name: "Sugapa" },
                { id: "intan_d007", name: "Ugimba" },
                { id: "intan_d008", name: "Wandai" }
            ]
        },
        {
            id: "nabire004",
            name: "Kabupaten Nabire",
            districts: [
                { id: "nabire_d001", name: "Nabire" },
                { id: "nabire_d002", name: "Nabire Barat" },
                { id: "nabire_d003", name: "Uwapa" },
                { id: "nabire_d004", name: "Wanggar" },
                { id: "nabire_d005", name: "Yaro" },
                { id: "nabire_d006", name: "Yaur" },
                { id: "nabire_d007", name: "Makimi" },
                { id: "nabire_d008", name: "Teluk Kimi" },
                { id: "nabire_d009", name: "Siriwo" },
                { id: "nabire_d010", name: "Napan" },
                { id: "nabire_d011", name: "Moora" },
                { id: "nabire_d012", name: "Menou" },
                { id: "nabire_d013", name: "Kepulauan Moora" }
            ]
        },
        {
            id: "puncak005",
            name: "Kabupaten Puncak",
            districts: [
                { id: "puncak_d001", name: "Beoga" },
                { id: "puncak_d002", name: "Doufo" },
                { id: "puncak_d003", name: "Gome" },
                { id: "puncak_d004", name: "Ilaga" },
                { id: "puncak_d005", name: "Sinak" },
                { id: "puncak_d006", name: "Wangbe" },
                { id: "puncak_d007", name: "Mewoluk" },
                { id: "puncak_d008", name: "Oneri" },
                { id: "puncak_d009", name: "Fawi" },
                { id: "puncak_d010", name: "Kamboneri" },
                { id: "puncak_d011", name: "Yugumuak" },
                { id: "puncak_d012", name: "Gome Utara" },
                { id: "puncak_d013", name: "Gome Selatan" }
            ]
        },
        {
            id: "puncakjaya006",
            name: "Kabupaten Puncak Jaya",
            districts: [
                { id: "puncakjaya_d001", name: "Fawi" },
                { id: "puncakjaya_d002", name: "Ilu" },
                { id: "puncakjaya_d003", name: "Jigonikme" },
                { id: "puncakjaya_d004", name: "Mulia" },
                { id: "puncakjaya_d005", name: "Torere" },
                { id: "puncakjaya_d006", name: "Yamo" },
                { id: "puncakjaya_d007", name: "Dokome" },
                { id: "puncakjaya_d008", name: "Gubume" },
                { id: "puncakjaya_d009", name: "Gurage" },
                { id: "puncakjaya_d010", name: "Irimuli" },
                { id: "puncakjaya_d011", name: "Kalome" },
                { id: "puncakjaya_d012", name: "Kiyage" },
                { id: "puncakjaya_d013", name: "Mage'Abume" },
                { id: "puncakjaya_d014", name: "Nioga" },
                { id: "puncakjaya_d015", name: "Taganombak" }
            ]
        },
        {
            id: 'Mimika1234',
            name: 'Kabupaten Mimika',
            districts: [
                { id: 'Tembaga123', name: 'Tembagapura' },
                { id: 'MimikaB01', name: 'Mimika Barat' },
                { id: 'MimikaB02', name: 'Mimika Barat Tengah' },
                { id: 'MimikaB03', name: 'Mimika Barat Jauh' },
                { id: 'MimikaB04', name: 'Mimika Timur' },
                { id: 'MimikaB05', name: 'Mimika Timur Jauh' },
                { id: 'MimikaB06', name: 'Mimika Tengah' },
                { id: 'MimikaB07', name: 'Agimuga' },
                { id: 'MimikaB08', name: 'Jila' },
                { id: 'MimikaB09', name: 'Jita' },
                { id: 'MimikaB10', name: 'Kuala Kencana' },
                { id: 'MimikaB11', name: 'Kwamki Narama' },
                { id: 'MimikaB12', name: 'Hoya' },
                { id: 'MimikaB13', name: 'Iwaka' },
                { id: 'MimikaB14', name: 'Amar' },
                { id: 'MimikaB15', name: 'Alama' },
                { id: 'MimikaB16', name: 'Mimika Baru' },
                { id: 'MimikaB17', name: 'Wania' }
            ]
        },
        {
            id: 'Paniai1234',
            name: 'Kabupaten Paniai',
            districts: [
                { id: 'PaniaiD01', name: 'Aradide' },
                { id: 'PaniaiD02', name: 'Bibida' },
                { id: 'PaniaiD03', name: 'Bogobaida' },
                { id: 'PaniaiD04', name: 'Dumadama' },
                { id: 'PaniaiD05', name: 'Ekadide' },
                { id: 'PaniaiD06', name: 'Kebo' },
                { id: 'PaniaiD07', name: 'Muye' },
                { id: 'PaniaiD08', name: 'Nabire Barat' },
                { id: 'PaniaiD09', name: 'Paniai Barat' },
                { id: 'PaniaiD10', name: 'Paniai Timur' },
                { id: 'PaniaiD11', name: 'Pugo' },
                { id: 'PaniaiD12', name: 'Siriwo' },
                { id: 'PaniaiD13', name: 'Teluk Kimi' },
                { id: 'PaniaiD14', name: 'Uwibutu' },
                { id: 'PaniaiD15', name: 'Yatamo' },
            ]
        }
    ],
    menus:[
        {
            name: "Home",
            path: "/",
            icon: "mdi-home-roof",
            role:  ['relawan',   'pemilih',  'admin' ],
            status : ['inactive','active']
        },
        {
            name: "Lengkapi Data Pemilih",
            path: "/completion-pemilih",
            icon: "mdi-phone",
            role:  ['pemilih'],
            status : ['inactive']
        },
        {
            name: "Lengkapi Data Relawan",
            path: "/completion-relawan",
            icon: "mdi-phone",
            role:  ['relawan'],
            status : ['inactive']
        },
        {
            name: "Report",
            path: "/report",
            icon: "mdi-phone",
            role:  ['admin'],
            status : ['active']
        },
    ]
  });
  
  const mutations = {
    SET_MENUS(state, menus) {
        state.menus = menus;
      }
  };
  
  const actions = {
    setDialog({ commit }, menus) {
        commit('SET_MENUS', menus);
      }
  };
  
  const getters = {
    regencies: (state) => state.regencies,
    menus : (state) => state.menus,
  };
  
  export default {
    state,
    mutations,
    actions,
    getters,
  };
  

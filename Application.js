import React, { Component } from "react";
import TitreH1 from "../../../components/Titre/TitreH1";
import axios from "axios";
import Items from "./Items/Items.js";
import Bouton from "../../../components/UI/Bouton/Bouton";

//REQUETE SQL

class Application extends Component {
    //state pour stocker les données récupérées

    state = {
        filtre_items_culture: null,
        filtreFamille: null,
        filtreCulture: null,
        listeCulture: null,
        listeFamille: null,
    }
    //se lancera à l'affichage de l'appli, va collecter les datas depuis le serveur (-1 = tout)
    loadData = () => {
        const famille = this.state.filtreFamille ? this.state.filtreFamille : "-1";
        const item = this.state.filtre_items_culture ? this.state.filtre_items_culture : "-1";

        axios.get(`https://my.ionos.fr/webhosting/2de9f77c-e417-4ec1-b26d-7e8f0bebe21f/databases/b8c5ae4f-dff2-44ff-8ed8-f18d62c0fca0/open`).then(reponse => {
            this.setState({ items: Object.values(reponse.data) });
        })
    }

    componentDidMount = () => {
        //appel de la fonction loadData ci-dessus
        this.loadData();
        axios.get(`https://my.ionos.fr/webhosting/2de9f77c-e417-4ec1-b26d-7e8f0bebe21f/databases/b8c5ae4f-dff2-44ff-8ed8-f18d62c0fca0/open`).then(reponse => {
            this.setState({
                listeFamille: Object.values(reponse.data)
            })
        
            axios.get(`https://my.ionos.fr/webhosting/2de9f77c-e417-4ec1-b26d-7e8f0bebe21f/databases/b8c5ae4f-dff2-44ff-8ed8-f18d62c0fca0/open`).then(reponse => {
                this.setState({
                    listeCulture: Object.values(reponse.data)
                });
            })
        }),
            
            //pour charger la page quand toutes les infos recherchées au clic sont relevées
            componentDidUpdate = (oldProps, oldState) => {
                if (oldState, filtreFamille !== this.state.filtreFamille || oldState.filtreItem == !this.filtreItem)
                    this.loadData();
            },
            //tri des différentes lorsque l'on appuie sur les différents boutons
            //tri par famille
            handleSelectionFamille = (id_famille) => {
                if (id_famille === "-1") this.handleResetFiltreFamille()
                else this.setState({ filtreFamille: id_famille });
            },
            //tri des items
            handleSelectionItem = (id_item) => {
                if (id_item === "-1") this.handleResetFiltreItem();
                console.log(`Demande de ${id_item}`);
                this.setState({ filtreItem: id_item });
            },
            handleSelectionCulture = (id_culture) => {
                if (id_item === "-1") this.handleResetFiltreCulture()
                else this.setState({ filtreCulture: id_culture });
            },
            handleResetFiltreFamille = () => {
                this.setState({ filtreFamille: null })
            },
            handleResetFiltreCulture = () => {
                this.setState({ filtreCulture: null })
            },
}

render() {
    let nomFamilleFiltre = "";
    if (this.state.filtreFamille) {
        const numCaseFamilleFiltre = this.state.listeFamille.findIndex(famille => {
            return famille.id_famille === this.state.filtreFamille;
        })
        nomFamilleFiltre = this.state.listeFamille[numCaseFamilleFiltre].nom_famille;
    }
    let nomCultureFiltre = "";
    if (this.state.filtreCulture) {
        const numCaseCultureFiltre = this.state.listeCulture.findIndex(culture => {
            return culture.nom_item === this.state.filtreCulture;
        })
        nomCultureFiltre = this.state.listeCulture[numCaseCultureFiltre].nom_item;
    }
    return (
        <>
            <TitreH1 bgColor="bg-success">Les plantations</TitreH1>
            <div className="container-fluid">
                <span> Filtres :<span/>
                    <select onChange={(event) => this.handleSelectionFamille(event.target.value)}>
                        <option value="-1" selected={this.state.filtreFamille === null && "selected"}>Familles</option>
                        {
                            this.state.listeFamille && this.state.listeFamille.map(famille => {
                                return <option
                                    value={famille.id_famille}
                                    selected={this.state.filtreFamille === famille.id_famille && "selected"}>{famille.nom_famille}</option> >
                            );
                        }
                    }
                    </select>

                    <select onChange={(event) => this.handleSelectionCulture(event.target.value)}>
                        <option value="-1" selected={this.state.filtreCulture === null && "selected"}>Facilité</option>
                        {
                            this.state.listeCulture && this.state.listeCulture.map(culture => {
                                return <option
                                    value={culture.id_item}
                                    selected={this.state.filtreCulture === culture.id_item && "selected"}>{culture.nom_item}</option> >
                            })
                        }
                    </select>

                    {
                        this.state.filtreFamille &&
                        <Bouton
                            typeBtn="btn-secondary"
                            clic={this.handleResetFiltreFamille}
                        >
                            {nomFamilleFiltre} &nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </Bouton>
                    }
                        
                    {
                        this.state.filtreCulture &&
                        <Bouton
                            typeBtn="btn-secondary"
                            clic={this.handleResetFiltreCulture}
                        >
                            {nomCultureFiltre} &nbsp;
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </Bouton>
                    }

                    {this.state.animaux.map(items_culture => {
                        return (
                            <div className="clo-12 col-md-6 col-xl-4" key={items_culture.id} >
                                <Items {...items}
                                    filtreItem={this.handleSelectionItem}
                                    filtreFamille={this.handleSelectionFamille}
                                />
                            </div>
                        )
                    })
                }
            </div>
            {/* </div> */}
        </>
    );
}

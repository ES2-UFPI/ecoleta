import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class PesquisaPorPontoDeColeta extends Component {
    constructor() {
        super();
    }

    state = {
        pontosDeColeta: [],
        search: ''
    }

    buscaPontosDeColeta = async (search, city) => {
        const string = search[0].toUpperCase() + search.substr(1);

        await api.get(`/admin/collect_point/search/${string}/city/${city}`).then(response => {
            this.setState({
                pontosDeColeta: response.data.data.collectPoint
            });
        });
    };

    componentDidMount() {
        this.setState({
            search: this.props.route.params.search
        });
        this.buscaPontosDeColeta(this.props.route.params.search, this.props.route.params.city);
    }

    render() {
        var pontos = [];
        if (this.state.pontosDeColeta !== undefined)
            pontos = this.state.pontosDeColeta.map((value, index) => {
                return { name: value.title, value: value.id, key: value.id }
            });

        const itensDoPontoDeColeta = (pontoDeColetaTitle, itemID) => {
            if (itemID)
                this.props.navigation.navigate('Itens do Ponto', { pontoDeColetaTitle, itemID });
        }

        return (
            <View style={styles.container} >
                <Button
                    style={{
                        width: 60,
                        marginLeft: 350
                    }}
                    icon={
                        <Icon
                            name='arrow-left'
                            size={15}
                            color='blue'
                        />
                    }
                    onPress={() => this.props.navigation.goBack()}
                />

                <Text h3>Pesquisa de Pontos de coleta</Text>
                <Text h5>Pesquisa por: {this.state.search}</Text>

                <ScrollView>
                    {pontos.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => itensDoPontoDeColeta(item.name, item.key)}
                            >{item.name}</Text>
                        </View>
                    ))
                    }
                </ScrollView>
            </View>
        );
    }
}

const styles = StyleSheet.create({
    item: {
        padding: 10,
        margin: 5,
        fontSize: 20,
        backgroundColor: '#eee',
    },
});
import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button, Input } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class Regiao extends Component {
    constructor() {
        super();
    }

    state = {
        mapRegion: {
            latitude: 37.78825,
            longitude: -122.4324,
            latitudeDelta: 0.0922,
            longitudeDelta: 0.0421,
        },
        regioes: [],
        textItem: '',
        region: '',
        city: ''
    }

    buscaRegioes = async (cityID) => {
        await api.get(`/admin/region/city/${cityID}`).then(response => {
            this.setState({
                regioes: response.data.data.regions
            });
        });
    };

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela Regiao');
            this.setState({
                city: this.props.route.params.cityID
            })
            this.buscaRegioes(this.props.route.params.cityID);
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {
        const regioes = this.state.regioes.map((value, index) => {
            return { name: value.title, value: value.id, key: value.id }
        });

        const pontosDeColeta = (pontoID) => {
            if (pontoID)
                this.props.navigation.navigate('Pontos de Coleta', { pontoID });
        }

        const pesquisarPorPonto = () => {
            if (this.state.textItem)
                this.props.navigation.navigate('Pesquisa de Pontos de Coleta', { search: this.state.textItem, city: this.state.city });
        }

        return (
            <View style={styles.container} >
                <Button
                title=' Voltar'
                    containerStyle={{
                        width: '100%', marginLeft: 0
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

                <Text h3>Regiões</Text>

                <Input
                    placeholder='Pesquisar por itens de descarte'
                    leftIcon={
                        <Icon
                            name='search'
                            size={24}
                            color='black'
                        />
                    }
                    onChangeText={value => this.setState({ textItem: value })}
                />
                <Button
                    containerStyle={{
                        width: '100%', marginLeft: 0
                    }}
                    icon={
                        <Icon
                            name='search'
                            size={15}
                            color='blue'
                        />
                    }
                    title=' Pesquisar'
                    onPress={() => pesquisarPorPonto()}
                />

                <Text h4 style={{marginTop: 10}}>Lista de regiões:</Text>
                <Text h5>Selecione uma região e visualize o mapa dos pontos de coleta.</Text>

                <ScrollView>
                    {regioes.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => pontosDeColeta(item.key)}
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
    }
});
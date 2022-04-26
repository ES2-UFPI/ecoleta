import React, { useState, Component } from 'react';
import { render } from 'react-dom';
import { StyleSheet, View, ScrollView } from 'react-native';
import { Text, Image, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class ItensDoPonto extends Component {
    constructor() {
        super();
    }

    state = {
        itens: [],
        pontoDeColetaTitle: ''
    }

    buscaItensDoPonto = async (pontoDeColetaTitle, itemID) => {
        await api.get(`/admin/collectionItem/collectPoint/${itemID}`).then(response => {
            this.setState({
                itens: response.data.data.collectionItems,
                pontoDeColetaTitle: pontoDeColetaTitle
            });
        });
    };

    componentDidMount() {
        const { pontoDeColetaTitle, itemID } = this.props.route.params;
        this.buscaItensDoPonto(pontoDeColetaTitle, itemID);
    }

    render() {
        const itens = this.state.itens.map((value, index) => {
            return { name: value.title, value: value.id, key: value.id }
        });

        console.log(itens);

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

                <Image
                    source={require('../../assets/recycle.jpg')}
                    style={{ width: 200, height: 200, marginTop: 20 }}
                />

                <Text h1>{this.state.pontoDeColetaTitle}</Text>
                <Text h4>Itens do Ponto de Coleta:</Text>
                <ScrollView>
                    {itens.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => console.log('clicou')}
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
    container: {
        flex: 1,
        backgroundColor: '#fff',
        alignItems: 'center',
        justifyContent: 'center',
    },

    item: {
        padding: 10,
        margin: 5,
        fontSize: 16,
        width: 300,
        backgroundColor: '#eee',
    },
});
import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class ResgateSacolaPendente extends Component {
    constructor() {
        super();
    }

    state = {
        resgateDeSacolasPendentes: []
    }

    buscaresgateDeSacolasPendentes = async () => {
        await api.get(`/admin/bag-rescue/rescues/pending`).then(response => {
            this.setState({
                resgateDeSacolasPendentes: response.data.data.bags
            });
        });
    };

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela ResgateSacolaPendente');
            this.buscaresgateDeSacolasPendentes();
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {
        const sacolas = this.state.resgateDeSacolasPendentes.map((value, index) => {
            return {
                name: value.bag.collect_point.title,
                value: value.bag.collect_point.id,
                key: value.id,
                items: value.bag.items,
            }
        });

        const verSacola = (items, bagRescueId) => {
            console.log('ver resgate de sacola pendente')
            this.props.navigation.navigate('Itens de Resgate Pendentes', { bagRescueId: bagRescueId, items: items });
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

                <ScrollView
                    style={{
                        padding: 10,
                        marginBottom: 10
                    }}
                >
                    {sacolas.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => verSacola(item.items, item.key)}
                            >
                                #{item.key} - {item.name}
                            </Text>
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
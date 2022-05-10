import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class SacolaPendente extends Component {
    constructor() {
        super();
    }

    state = {
        sacolasPendentes: []
    }

    buscaSacolasPendentes = async () => {
        await api.get(`/admin/bags/pending`).then(response => {
            this.setState({
                sacolasPendentes: response.data.data.bags
            });
        });
    };

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela SacolaPendente');
            this.buscaSacolasPendentes();
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {
        const sacolas = this.state.sacolasPendentes.map((value, index) => {
            return {
                key: value.id,
                name: value.collect_point.title,
                value: value.collect_point.id,
                items: value.item,
            }
        });

        const verSacola = (bag_id, items) => {
            this.props.navigation.navigate('Itens Pendentes', { bag_id: bag_id, items: items });
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
                        padding: 10
                    }}
                >
                    {sacolas.map(item => (
                        <View key={item.key}>
                            <Text
                                style={styles.item}
                                onPress={() => verSacola(item.key, item.items)}
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
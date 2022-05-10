import React, { useState, Component } from 'react';
import { Alert, ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

import api from '../services/api';

export default class ItensDeResgatePendentes extends Component {
    constructor() {
        super();
    }

    state = {
        items: [],
        bagRescueId: ''
    }

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela ItensDeResgatePendentes');
            const { items, bagRescueId } = this.props.route.params;
            this.setState({
                items: items,
                bagRescueId: bagRescueId
            });
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {

        const finalizarSacola = async () => {
            await api.put(`/admin/bag-rescue/${this.state.bagRescueId}`, { recue: true }).then(response => {
                console.log('resgate de sacola realizada com sucesso!');
                Alert.alert('Resgate de sacola realizada com sucesso!');
                this.props.navigation.navigate('Resgate de Sacolas Finalizadas');
            });
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

                <Text h3>Itens</Text>

                <ScrollView>
                    {this.state.items.map(item => (
                        <View key={item.id}>
                            <Text
                                style={styles.item}
                            >
                                {item.collectionItem.title}
                            </Text>
                            <Text h6>Qtd.: {item.quantity}</Text>
                        </View>
                    ))
                    }
                </ScrollView>

                <Button
                    containerStyle={{
                        width: '100%', marginLeft: 0
                    }}
                    title=' Confirmar retirada'
                    icon={
                        <Icon
                            name='trash'
                            size={15}
                            color='blue'
                        />
                    }
                    onPress={() => finalizarSacola()}
                />
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
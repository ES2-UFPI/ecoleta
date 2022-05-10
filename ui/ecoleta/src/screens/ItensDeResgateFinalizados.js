import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

export default class ItensDeResgateFinalizados extends Component {
    constructor() {
        super();
    }

    state = {
        items: []
    }

    componentDidMount() {
        this._unsubscribe = this.props.navigation.addListener('focus', () => {
            console.log('Atualizando tela ItensDeResgateFinalizados');
            const { items } = this.props.route.params;
            this.setState({
                items: items
            });
        });
    }

    componentWillUnmount() {
        this._unsubscribe();
    }

    render() {

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
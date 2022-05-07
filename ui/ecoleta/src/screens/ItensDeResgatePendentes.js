import React, { useState, Component } from 'react';
import { ScrollView, StyleSheet, View } from 'react-native';
import { Text, Button } from 'react-native-elements';
import Icon from 'react-native-vector-icons/FontAwesome';

export default class ItensDeResgatePendentes extends Component {
    constructor() {
        super();
    }

    state = {
        items: []
    }

    componentDidMount() {
        const { items } = this.props.route.params;
        this.setState({
            items: items
        });
    }

    render() {

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